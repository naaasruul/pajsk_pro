<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\ClubPosition;
use App\Models\Commitment;
use App\Models\PajskAssessment;
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
            'attendance' => 'required|numeric|min:1|max:12',
            'commitments' => 'required|array|size:4',
            'commitments.*' => 'exists:commitments,id',
            'service_contribution_id' => 'required|exists:service_contributions,id',
        ]);

        $attendance = Attendance::where('attendance_count', $validated['attendance'])->firstOrFail();
        $commitments = Commitment::whereIn('id', $validated['commitments'])->get();
        $serviceContribution = ServiceContribution::find($validated['service_contribution_id']);
        
        $scores = [
            'attendance_score' => $attendance->score,
            'position_score' => $student->getCurrentPositionAttribute()?->point ?? 0,
            'involvement_score' => $student->getInvolvementScore(),
            'commitment_score' => $commitments->sum('score'),
            'service_score' => $serviceContribution->score,
            'achievement_score' => $this->calculateAchievementScore($student)
        ];

        $total = array_sum($scores);
        $percentage = ($total / 110) * 100;

        // Create new PAJSK assessment record
        $assessment = PajskAssessment::create([
            'student_id' => $student->id,
            'teacher_id' => auth()->user()->teacher->id,
            'attendance_score' => $scores['attendance_score'],
            'position_score' => $scores['position_score'],
            'involvement_score' => $scores['involvement_score'],
            'commitment_score' => $scores['commitment_score'],
            'service_score' => $scores['service_score'],
            'achievement_score' => $scores['achievement_score'],
            'total_score' => $total,
            'percentage' => $percentage,
            'commitment_ids' => $validated['commitments'],
            'service_contribution_id' => $validated['service_contribution_id']
        ]);

        session()->flash('evaluation_review', [
            'scores' => $scores,
            'total' => $total,
            'percentage' => $percentage,
            'student' => $student,
            'commitments' => $commitments,
            'service' => $serviceContribution,
            'assessment' => $assessment
        ]);

        return redirect()->route('pajsk.review', $student);
    }

    public function review(Student $student)
    {
        if (!session()->has('evaluation_review')) {
            return redirect()->route('pajsk.evaluate-student', $student);
        }

        $review = session('evaluation_review');
        return view('pajsk.review', $review);
    }

    public function evaluations()
    {
        $evaluations = PajskAssessment::with(['student.user', 'serviceContribution'])
            ->where('teacher_id', auth()->user()->teacher->id)
            ->latest()
            ->paginate(10);

        return view('pajsk.evaluations', compact('evaluations'));
    }
}
