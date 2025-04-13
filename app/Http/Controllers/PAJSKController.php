<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\ClubPosition;
use App\Models\Commitment;
use App\Models\ServiceContribution;
use Illuminate\Http\Request;

class PAJSKController extends Controller
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

        return view('pajsk.index', compact('club', 'studentsWithPositions', 'positions'));
    }

    public function evaluateStudent(Student $student)
    {
        $student->load(['activities.involvement', 'activities.achievement', 'activities.placement', 'clubs']);
        $position = $student->current_position;
        $club = $student->current_club;
        
        return view('pajsk.evaluate', [
            'student' => $student,
            'club' => $club,
            'position' => $position,
            'attendanceScores' => Attendance::all(),
            'commitments' => Commitment::all(),
            'serviceContributions' => ServiceContribution::all(),
            'involvementScore' => $student->getInvolvementScore(),
            'achievementScore' => $this->calculateAchievementScore($student)
        ]);
    }

    private function calculateAchievementScore(Student $student): int
    {
        $maxScore = 0;
        
        foreach ($student->activities as $activity) {
            if (!$activity->achievement || !$activity->placement_id) continue;
            
            // Get score from achievement_placement pivot
            $placementScore = $activity->achievement->placements()
                ->where('placement_id', $activity->placement_id)
                ->first()?->pivot->score ?? 0;
                
            // Get score from achievement_involvement pivot
            $involvementScore = $activity->achievement->involvements()
                ->where('involvement_type_id', $activity->involvement_id)
                ->first()?->pivot->score ?? 0;
            
            // Take highest score found
            $maxScore = max($maxScore, $placementScore + $involvementScore);
        }
        
        return min($maxScore, 20); // Cap at 20 points
    }

    public function storeEvaluation(Request $request, Student $student)
    {
        $validated = $request->validate([
            'attendance' => 'required|exists:attendances,id',
            'commitments' => 'required|array|size:4',
            'commitments.*' => 'exists:commitments,id',
            'service_contribution' => 'required|exists:service_contributions,id',
        ]);

        // Calculate total score (110 possible points)
        $attendance = Attendance::find($validated['attendance']);
        $commitments = Commitment::whereIn('id', $validated['commitments'])->get();
        $serviceContribution = ServiceContribution::find($validated['service_contribution']);
        
        $totalScore = 
            $attendance->score + // Max 40
            ($student->clubPosition?->point ?? 0) + // Max 10
            $student->getInvolvementScore() + // Max 20
            $commitments->sum('score') + // Max 10
            $serviceContribution->score + // Max 10
            $this->calculateAchievementScore($student); // Max 20

        $percentage = ($totalScore / 110) * 100;

        return redirect()->route('pajsk.index')
            ->with('success', "PAJSK Score: {$totalScore}/110 ({$percentage}%)");
    }
}
