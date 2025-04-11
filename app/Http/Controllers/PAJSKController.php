<?php

namespace App\Http\Controllers;

use App\Models\AttendanceScore;
use App\Models\Club;
use App\Models\ClubPosition;
use App\Models\CommitmentScore;
use App\Models\ServiceContributionScore;
use App\Models\Student;
use Illuminate\Http\Request;

class PAJSKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('pajsk.index', compact('club', 'studentsWithPositions', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function evaluateStudent(Student $student)
    {
        $teacher = auth()->user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('pajsk.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Get student's current position in club
        $studentClub = $club->students()->where('student_id', $student->id)->first();
        $position = $studentClub ? ClubPosition::find($studentClub->pivot->club_position_id) : null;

        // Get available options for form
        $attendanceScores = AttendanceScore::orderBy('attendance_count')->get();
        $commitments = CommitmentScore::all();
        $serviceContributions = ServiceContributionScore::all();

        return view('pajsk.evaluate', compact(
            'student',
            'club',
            'position',
            'attendanceScores',
            'commitments',
            'serviceContributions'
        ));
    }

    public function storeEvaluation(Request $request, Student $student)
    {
        $validated = $request->validate([
            'attendance_count' => 'required|integer|min:1|max:12',
            'commitments' => 'required|array|size:4',
            'commitments.*' => 'required|exists:commitments,id',
            'service_contribution_id' => 'required|exists:service_contributions,id',
        ]);

        $teacher = auth()->user()->teacher;
        $club = $teacher ? $teacher->club : null;

        if (!$club) {
            return redirect()->route('pajsk.index')
                ->with('error', 'You are not assigned to any club.');
        }

        // Calculate scores
        $attendanceScore = AttendanceScore::where('attendance_count', $validated['attendance_count'])->first()->score;
        $commitmentScore = CommitmentScore::whereIn('id', $validated['commitments'])->sum('score');
        $serviceScore = ServiceContributionScore::find($validated['service_contribution_id'])->score;

        // Get position score
        $studentClub = $club->students()->where('student_id', $student->id)->first();
        $positionScore = 0;
        if ($studentClub && $studentClub->pivot->club_position_id) {
            $position = ClubPosition::find($studentClub->pivot->club_position_id);
            $positionScore = $position ? $position->point : 0;
        }

        // Store evaluation
        $evaluation = $student->evaluations()->create([
            'teacher_id' => $teacher->id,
            'club_id' => $club->id,
            'attendance_score' => $attendanceScore,
            'position_score' => $positionScore,
            'commitment_score' => $commitmentScore,
            'service_contribution_score' => $serviceScore,
            'total_score' => $attendanceScore + $positionScore + $commitmentScore + $serviceScore,
        ]);

        // Attach selected commitments
        $evaluation->commitments()->attach($validated['commitments']);

        return redirect()->route('pajsk.index')
            ->with('success', 'Student evaluation completed successfully.');
    }
}
