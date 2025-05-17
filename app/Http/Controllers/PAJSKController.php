<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Club;
use App\Models\ClubPosition;
use App\Models\Commitment;
use App\Models\PajskAssessment;
use App\Models\PajskReport;
use App\Models\ServiceContribution;
use App\Models\Teacher;
use App\Models\ExtraCocuricullum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PAJSKController extends Controller
{
    public function index() 
    {
        $teacher = Teacher::with('club')->whereNotNull('club_id')->first();
        if (!$teacher || !$teacher->club) {
            abort(404, 'No club assigned. Please contact administrator.');
        }

        $club = Club::with('students.user')->find($teacher->club_id);
        $positions = ClubPosition::all();
        
        // Get paginated students from the club
        $students = $club->students()->with('user')->paginate(10);
        
        $studentsWithPositions = $students->map(function ($student) use ($positions) {
            $position = $student->pivot->club_position_id
                ? $positions->find($student->pivot->club_position_id)
                : null;

            return [    
                'id' => $student->id,
                'user' => [
                    'name' => $student->user->name,
                    'classroom' => [
                        'year' => $student->classroom->year,
                        'class_name' => $student->classroom->class_name,
                    ],
                ],
                'position_name' => $position ? $position->position_name : 'No Position',
            ];
        });

        return view('pajsk.index', [
            'club' => $club,
            'studentsWithPositions' => $studentsWithPositions,
            'positions' => $positions,
            'teacher' => $teacher,
            'students' => $students // Pass the paginator instance
        ]);
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
            'placementScore' => $student->getPlacementScore()
        ]);
    }

    private function calculateAchievementScore(Student $student): int
    {
        $maxScore = 0;
        
        foreach ($student->activities as $activity) {
            // Skip if missing required relations
            if (!$activity->achievement) continue;
            
            // Get score based on placement if exists
            if ($activity->placement_id) {
                $placementScore = $activity->achievement->placements()
                    ->where('placement_id', $activity->placement_id)
                    ->first()?->pivot->score ?? 0;
                    
                if ($placementScore > 0) {
                    $maxScore = max($maxScore, $placementScore);
                    continue; // Skip involvement check if we got placement score
                }
            }

            // Fallback to involvement score if no placement or placement score
            $involvementScore = $activity->achievement->involvements()
                ->where('involvement_type_id', $activity->involvement_id)
                ->first()?->pivot->score ?? 0;
            
            $maxScore = max($maxScore, $involvementScore);
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
        
        $attendanceRecord = Attendance::where('attendance_count', $validated['attendance'])->firstOrFail();
        $serviceContribution = ServiceContribution::find($validated['service_contribution_id']);

        $clubPositionId = $student->clubPosition();
        $firstActivity = $student->activities()->first();
        $involvementId = $firstActivity ? $firstActivity->involvement_id : null;
        $placementId = $firstActivity ? $firstActivity->placement_id : null;
        $commitmentIds = $validated['commitments'];
        $serviceIds = [$validated['service_contribution_id']];

        $attendancePoint    = $attendanceRecord->score;
        $clubPositionPoint  = $clubPositionId ? (\App\Models\ClubPosition::find($clubPositionId)->point ?? 0) : 0;
        $involvementScore   = $student->getInvolvementScore();
        $commitmentScore    = Commitment::whereIn('id', $validated['commitments'])->sum('score');
        $serviceScore       = $serviceContribution->score;
        $achievementScore   = $this->calculateAchievementScore($student);
        $totalScore         = $attendancePoint + $clubPositionPoint + $involvementScore + $commitmentScore + $serviceScore + $achievementScore;
        $percentage         = round(($totalScore / 110) * 100, 2);
        
        // Retrieve existing assessment if available; otherwise, create new.
        $assessment = PajskAssessment::firstOrNew([
            'student_id' => $student->id,
            'class_id'   => $student->classroom->id,
        ]);

        // For array fields, merge new values with existing values.
        $assessment->teacher_ids = array_merge($assessment->teacher_ids ?? [], [auth()->user()->teacher->id]);
        
        // Replace merging of club_ids with conditional assignment
        if (empty($assessment->club_ids)) {
            $assessment->club_ids = $student->clubs->pluck('id')->toArray();
        }
        
        $assessment->club_position_ids = array_merge($assessment->club_position_ids ?? [], $clubPositionId ? [$clubPositionId] : []);
        $assessment->service_contribution_ids = array_merge($assessment->service_contribution_ids ?? [], [$validated['service_contribution_id']]);
        $assessment->attendance_ids = array_merge($assessment->attendance_ids ?? [], [$attendanceRecord->id]);
        
        // For singular fields, set if not already set.
        if (!$assessment->involvement_id) {
            $assessment->involvement_id = $involvementId;
        }
        if (!$assessment->placement_id) {
            $assessment->placement_id = $placementId;
        }
        
        // For commitment_ids, which must be a 2D array
        if (!empty($assessment->commitment_ids)) {
            $assessment->commitment_ids = array_merge($assessment->commitment_ids, [$commitmentIds]);
        } else {
            $assessment->commitment_ids = [$commitmentIds];
        }
        $assessment->service_ids = array_merge($assessment->service_ids ?? [], $serviceIds);
        $assessment->total_scores = array_merge($assessment->total_scores ?? [], [$totalScore]);
        $assessment->percentages  = array_merge($assessment->percentages ?? [], [$percentage]);
        
        $assessment->save();
        
        return redirect()->route('pajsk.result', ['student' => $student, 'evaluation' => $assessment]);
    }

    public function result(Student $student, PajskAssessment $evaluation)
    {
        if ($evaluation->student_id !== $student->id) {
            Log::error('PAJSK assessment authorization failed', [
                'student_id' => $student->id,
                'assessment_student_id' => $evaluation->student_id,
                'assessment_id' => $evaluation->id
            ]);
            abort(404);
        }

        $extracocuricullum = ExtraCocuricullum::where('student_id', $student->id)
                                ->where('class_id', $student->classroom->id)
                                ->first();
        
        $attendance = Attendance::find(collect($evaluation->attendance_ids)->first());
        // Keep the id arrays unchanged: total_scores & percentages still hold multiple breakdown values.
        $totalScores  = $evaluation->total_scores ?? [];  
        $percentages  = $evaluation->percentages ?? [];
        
        // Sort activities in descending order by placement pivot score from achievement_placement pivot
        $sortedActivities = $student->activities->sortByDesc(function($activity) {
            $placementScore = $activity->achievement->placements()
                ->where('placement_id', $activity->placement_id)
                ->first()?->pivot->score ?? 0;
            return $placementScore;
        });

        $scores = [
            'attendance' => [
                'ids' => $evaluation->attendance_ids,
                'scores' => array_map(function($id) {
                    $att = Attendance::find($id);
                    return $att ? $att->score : 0;
                }, $evaluation->attendance_ids ?? []),
            ],
            'club_positions' => [
                'ids' => $evaluation->club_position_ids,
                'scores' => array_map(function($id) {
                    $cp = \App\Models\ClubPosition::find($id);
                    return $cp ? $cp->point : 0;
                }, $evaluation->club_position_ids ?? []),
            ],
            'commitments' => [
                'ids' => $evaluation->commitment_ids,
                'scores' => array_map(function($idArray) {
                    $scores = array_map(function($id) {
                        $comm = \App\Models\Commitment::find($id);
                        return $comm ? $comm->score : 0;
                    }, $idArray);
                    return [array_sum($scores)];
                }, $evaluation->commitment_ids ?? []),
            ],
            'services' => [
                'ids' => $evaluation->service_ids,
                'scores' => array_map(function($id) {
                    $serv = ServiceContribution::find($id);
                    return $serv ? $serv->score : 0;
                }, $evaluation->service_ids ?? []),
            ],
            'involvement' => [
                'id' => $evaluation->involvement_id,
                'score' => $evaluation->involvement_id ? $student->getInvolvementScore() : 0,
            ],
            'placement' => [
                'id' => $evaluation->placement_id,
                'score' => $evaluation->placement_id ? $student->getPlacementScore() : 0,
            ],
            'totalScores' => $totalScores,
            'percentages' => $percentages,
        ];

        // $commitments = $evaluation->commitments()->get();
        $service = ServiceContribution::find(optional($evaluation->service_contribution_ids)[0]);

        // Pass full id arrays along with breakdown arrays to the view.
        $result = [
            'scores' => $scores,
            'totalScores' => $totalScores,
            'percentages' => $percentages,
            'student' => $student,
            'teacher_ids' => $evaluation->teacher_ids,
            'year' => $evaluation->classroom->year,
            'class_name' => $evaluation->classroom->class_name,
            'club_ids' => $evaluation->club_ids,
            'position' => optional($evaluation->club_positions->first())->position_name,
            'attendance' => $attendance,
            'service' => $service,
            'assessment' => $evaluation,
            'extracocuricullum' => $extracocuricullum,
            'sortedActivities' => $sortedActivities, // pass sorted activities to the view
        ];
        
        return view('pajsk.result', $result);
    }

    public function history(Request $request)
    {
        $teacher = Teacher::with('club')->whereNotNull('club_id')->first();
        if (!$teacher || !$teacher->club) {
            abort(404, 'No club assigned. Please contact administrator.');
        }
        $club = Club::with('students.user')->find($teacher->club_id);

        $search = $request->get('search');
        $year_filter = $request->get('year_filter');
        $class_filter = $request->get('class_filter');
        // $club_filter = $request->get('club_filter');
        // $club_category = $request->get('club_category');

        // Retrieve all clubs to populate the filter dropdown
        $clubs = Club::orderBy('club_name')->get();

        if (auth()->user()->hasrole('admin')) {
            $query = PajskAssessment::with(['student.user', 'serviceContribution', 'classroom']);
        } else if (auth()->user()->hasrole('teacher')) {
            $query = PajskAssessment::with(['student.user', 'serviceContribution', 'classroom'])
                ->whereJsonContains('teacher_ids', auth()->user()->teacher->id);
        } else if (auth()->user()->hasrole('student')) {
            $query = PajskAssessment::with(['student.user', 'serviceContribution', 'classroom'])
                ->where('student_id', auth()->user()->student->id);
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Search by student name or class name
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('student.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('classroom', function($q) use ($search) {
                    $q->where('class_name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by year
        if ($year_filter) {
            $query->whereHas('classroom', function ($q) use ($year_filter) {
                $q->where('year', $year_filter);
            });
        }

        // Filter by class name
        if ($class_filter) {
            $query->whereHas('classroom', function($q) use ($class_filter) {
                $q->where('class_name', $class_filter);
            });
        }

        // Get unique class names for filter dropdown
        $classNames = Classroom::select('class_name')
                            ->distinct()
                            ->orderBy('class_name')
                            ->pluck('class_name');
        // if ($club_filter) {
        //     $query->where('club_id', $club_filter);
        // }
        // if ($club_category) {
        //     $query->whereHas('club', function ($q) use ($club_category) {
        //         $q->where('category', $club_category);
        //     });
        // }

        $evaluations = $query->latest()->paginate(10);

        return view('pajsk.history', compact('evaluations', 'club', 'teacher', 'clubs', 'classNames'));
    }

    public function generateReport(Student $student, PajskAssessment $assessment)
    {
        // Retrieve the previous year from the current assessment's classroom year.
        $previousYear = $assessment->classroom->year > 1 ? $assessment->classroom->year - 1 : $assessment->classroom->year;
        // Find the older assessment for the same student in the previous year.
        $oldAssessment = PajskAssessment::where('student_id', $student->id)
                        ->whereHas('classroom', function($q) use ($previousYear) {
                            $q->where('year', $previousYear);
                        })->latest()->first();
        $cgpaLast = $oldAssessment ? $oldAssessment->cgpa : null;

        // Calculate GPA from the total_scores array
        $scores = $assessment->total_scores ?? [];
        rsort($scores);
        if(count($scores) >= 2){
            $gpa = ($scores[0] + $scores[1]) / 2;
        } elseif(count($scores) == 1) {
            $gpa = $scores[0];
        } else {
            $gpa = 0;
        }
        // For demonstration, we use cgpa equal to gpa; adjust as needed
        $cgpa = $gpa;
        $cgpa_pctg = round($cgpa * 0.1, 2);
        $report_description = $cgpa >= 80 ? 'Excellent' : ($cgpa >= 60 ? 'Good' : 'Needs Improvement');
        
        // Create a new PajskReport record in the pajsk_reports table
        $report = PajskReport::create([
            'student_id' => $student->id,
            'class_id'   => $assessment->class_id,
            'extra_cocuricullum_id' => optional($student->extraCocuriculum)->id,
            'pajsk_assessment_id' => $assessment->id,
            'gpa' => $gpa,
            'cgpa' => $cgpa,
            'cgpa_pctg' => $cgpa_pctg,
            'report_description' => $report_description,
        ]);
        
        // Change the route name to match the registered route: 'pajsk.show-report'
        return redirect()->route('pajsk.show-report', ['student' => $student->id, 'report' => $report->id]);
    }

    public function reportHistory(Request $request)
    {
        // Retrieve reports with related student and classroom data
        $reports = PajskReport::with(['student.user', 'classroom'])
                    ->latest()
                    ->paginate(10);
        return view('pajsk.report-history', ['reports' => $reports]);
    }

    public function showReport(Student $student, PajskReport $report)
    {
        if ($report->student_id !== $student->id) {
            abort(404, 'Report not found for the given student.');
        }
        $assessment = PajskAssessment::find($report->pajsk_assessment_id);
        $extracocuricullum = ExtraCocuricullum::find($report->extra_cocuricullum_id);
        
        // Collect clubs from assessment based on club_ids.
        $clubsCollection = collect($assessment->club_ids ?? [])->map(function($id) {
            return Club::find($id);
        })->filter();
        $sukan  = $clubsCollection->firstWhere('category', 'Sukan & Permainan');
        $kelab  = $clubsCollection->firstWhere('category', 'Kelab & Persatuan');
        $badan  = $clubsCollection->firstWhere('category', 'Badan Beruniform');
        $clubs = collect([$sukan, $kelab, $badan]);

        // Collect positions based on the stored club_position_ids.
        $positions = collect($assessment->club_position_ids ?? [])->map(function($id) {
            return ClubPosition::find($id);
        })->filter();

        return view('pajsk.report', [
            'report'            => $report,
            'student'           => $student,
            'extracocuricullum' => $extracocuricullum,
            'assessment'        => $assessment,
            'clubs'             => $clubs,
            'positions'         => $positions,
        ]);
    }
}
