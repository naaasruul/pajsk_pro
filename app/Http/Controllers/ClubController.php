<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubPosition;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        $club = $teacher ? $teacher->club : null;
        $positions = ClubPosition::all();

        $studentsWithPositions = collect();

        if ($club) {
            $studentsWithPositions = $club->students->map(function ($student) use ($positions) {
                $position = $student->pivot->club_position_id
                    ? $positions->find($student->pivot->club_position_id)
                    : null;

                return [
                    'id' => $student->id,
                    'user' => [
                        'name' => $student->user->name,
                        'student' => [
                            'class' => $student->class
                        ]
                    ],
                    'position_name' => $position ? $position->position_name : 'No Position',
                ];
            });
        }

        return view('club.index', compact('club', 'studentsWithPositions', 'positions'));
    }

    public function showAddStudentForm()
    {
        $teacher = auth()->user()->teacher;
        $club = $teacher ? $teacher->club : null;
        
        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Get students not already in this club
        $existingStudentIds = $club->students->pluck('id');
        $availableStudents = Student::with('user')
            ->whereNotIn('id', $existingStudentIds)
            ->get();
        
        $positions = ClubPosition::all();
        
        return view('club.add-student', compact('club', 'availableStudents', 'positions'));
    }

    public function addStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'position_id' => 'required|exists:club_positions,id',
        ]);

        $teacher = auth()->user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('club.index')
                ->with('error', 'You are not assigned to any club.');
        }

        $club->students()->attach($validated['student_id'], [
            'club_position_id' => $validated['position_id']
        ]);

        return redirect()->route('club.index')
            ->with('success', 'Student added to club successfully.');
    }

    public function removeStudent(Request $request, $studentId)
    {
        $teacher = auth()->user()->teacher;
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
