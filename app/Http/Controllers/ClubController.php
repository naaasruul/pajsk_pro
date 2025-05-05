<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Club;
use App\Models\ClubPosition;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    protected $positionLimits = [
        1 => 1,  // President - 1 student
        2 => 1,  // Vice President - 1 student 
        3 => 1,  // Secretary - 1 student
        4 => 1,  // Treasurer - 1 student
        5 => 2,  // Committee Member - 2 students
        6 => null // Member - unlimited
    ];

    public function index()
    {
        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;
        $students = $club->students()->with('user')->paginate(10);
        $positions = ClubPosition::all();

        $studentsWithPositions = collect();
        $genderCounts = ['male' => 0, 'female' => 0];

        if ($club) {
            $studentsWithPositions = $club->students->map(function ($student) use ($club, $positions, &$genderCounts) {
                // Access pivot data for the specific club
                $pivotData = $student->clubs->where('id', $club->id)->first()?->pivot;

                $position = $pivotData && $pivotData->club_position_id
                    ? $positions->find($pivotData->club_position_id)
                    : null;

                // Count genders
                $gender = strtolower($student->user->gender);
                if (in_array($gender, ['male', 'female'])) {
                    $genderCounts[$gender]++;
                }

                return [
                    'id' => $student->id,
                    'user' => [
                        'name' => $student->user->name,
                        'gender' => $student->user->gender,
                        'classroom' => [
                            'year' => $student->classroom->year,
                            'class_name' => $student->classroom->class_name,
                        ],
                    ],
                    'position_name' => $position ? $position->position_name : 'No Position',
                ];
            });
        }

        return view('club.index', compact(
            'club',
            'studentsWithPositions',
            'positions',
            'genderCounts',
            'students' 
        ));
    }

    public function showAddStudentForm(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Get students not already in this club
        $existingStudentIds = $club->students->pluck('id');
        $availableStudentsQuery = Student::with('user', 'classroom')
            ->whereNotIn('id', $existingStudentIds);

        if ($request->filled('year')) {
            $availableStudentsQuery->whereHas('classroom', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }

        if ($request->filled('class_name')) {
            $availableStudentsQuery->whereHas('classroom', function ($q) use ($request) {
                $q->where('class_name', 'LIKE', '%' . $request->class_name . '%');
            });
        }

        // Group available students by year then by class_name
        $availableStudents = $availableStudentsQuery->get();
        $groupedStudents = $availableStudents->groupBy(fn($student) => $student->classroom->year)->map(function($students) {
            return $students->groupBy(fn($student) => $student->classroom->class_name);
        });
        $years = Classroom::select('year')->distinct()->pluck('year');
        $positions = ClubPosition::all();

        return view('club.add-student', compact('club', 'availableStudents', 'groupedStudents', 'positions', 'years'));
    }

    public function addStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'position_id' => 'required|exists:club_positions,id',
        ]);

        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Get the position being assigned
        $position = ClubPosition::find($validated['position_id']);
        
        // Check position limits
        if (isset($this->positionLimits[$position->ranking]) && $this->positionLimits[$position->ranking] !== null) {
            $currentCount = $club->students()
                ->whereHas('clubs', function($query) use ($club, $position) {
                    $query->where('club_id', $club->id)
                        ->whereIn('club_position_id', 
                            ClubPosition::where('ranking', $position->ranking)->pluck('id')
                        );
                })->count();

            if ($currentCount >= $this->positionLimits[$position->ranking]) {
                $positionName = $position->position_name;
                $maxAllowed = $this->positionLimits[$position->ranking];
                return redirect()->back()
                    ->with('error', "Cannot add more than {$maxAllowed} student(s) with {$positionName} position.");
            }
        }

        $club->students()->attach($validated['student_id'], [
            'club_position_id' => $validated['position_id']
        ]);

        return redirect()->route('club.index')
            ->with('success', 'Student added to club successfully.');
    }

    public function editStudent(Student $student)
    {
        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Check if student belongs to this club
        if (!$club->students->contains($student->id)) {
            return redirect()->route('club.index')
                ->with('error', 'Student is not in your club.');
        }

        $positions = ClubPosition::all();
        $currentPosition = $club->students()->where('student_id', $student->id)->first()->pivot->club_position_id;

        return view('club.edit-student', compact('club', 'student', 'positions', 'currentPosition'));
    }

    public function updateStudent(Request $request, Student $student)
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:club_positions,id',
        ]);

        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Get the new position being assigned
        $position = ClubPosition::find($validated['position_id']);
        
        // Get current position ID
        $currentPositionId = $club->students()->where('student_id', $student->id)->first()->pivot->club_position_id;
        
        // Only check limits if:
        // 1. We're changing to a different position
        // 2. The new position has a limit
        if ($currentPositionId !== $validated['position_id'] && 
            isset($this->positionLimits[$position->ranking]) && 
            $this->positionLimits[$position->ranking] !== null) {

            // Count current students in the target ranking, excluding this student
            $currentCount = $club->students()
                ->whereHas('clubs', function($query) use ($club, $position) {
                    $query->where('club_id', $club->id)
                        ->whereIn('club_position_id', 
                            ClubPosition::where('ranking', $position->ranking)->pluck('id')
                        );
                })
                ->where('students.id', '!=', $student->id)
                ->count();

            if ($currentCount >= $this->positionLimits[$position->ranking]) {
                $positionName = $position->position_name;
                $maxAllowed = $this->positionLimits[$position->ranking];
                return redirect()->back()
                    ->with('error', "Cannot have more than {$maxAllowed} student(s) with {$positionName} position.");
            }
        }

        // Update the student's position
        $club->students()->updateExistingPivot($student->id, [
            'club_position_id' => $validated['position_id']
        ]);

        return redirect()->route('club.index')
            ->with('success', 'Student position updated successfully.');
    }

    public function removeStudent(Request $request, $studentId)
    {
        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        $club->students()->detach($studentId);

        return redirect()->route('club.index')
            ->with('success', 'Student removed from club successfully.');
    }
}
