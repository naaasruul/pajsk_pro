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
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Placement;
use App\Models\Teacher;
use App\Models\ExtraCocuricullum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PAJSKController extends Controller
{
    public function index() 
    {
        $teacher = Auth::user()->teacher;
        $club = $teacher ? $teacher->club : null;
        $positions = ClubPosition::all();
        
        // Get paginated students from the club
        $students = $club->students()->with('user')->paginate(10);
        
        $studentsWithPositions = $students->map(function ($student) use ($positions, $club) {
            $assessment = PajskAssessment::where('student_id', $student->id)
                ->where('class_id', $student->classroom->id)
                ->whereJsonContains('club_ids', $club->id)
                ->first();

            $position = $student->pivot->club_position_id
                ? $positions->find($student->pivot->club_position_id)
                : null;

            // Determine club category index
            $categoryIndex = null;
            if (in_array($club->category, ['Sukan & Permainan', 'Sukan'])) {
                $categoryIndex = 0;
            } elseif (in_array($club->category, ['Kelab & Persatuan', 'Kelab & Permainan'])) {
                $categoryIndex = 1;
            } elseif ($club->category == 'Badan Beruniform') {
                $categoryIndex = 2;
            }

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
                'has_assessment' => !is_null($assessment) && 
                    $assessment->class_id === $student->classroom->id &&
                    isset($assessment->total_scores[$categoryIndex]) && 
                    $assessment->total_scores[$categoryIndex] > 0,
                'assessment_id' => $assessment?->id
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
        // Removed eager loading of activities relationships since "activities" is an accessor
        $student->load(['clubs']);
        $teacher = Auth::user()->teacher;
        $teacherClub = $teacher->club;
        Log::info('Teacher Club:', [
            'teacher_id' => $teacher->id,
            'club_id' => $teacherClub->id,
        ]);
        $clubActivities = $student->activities->filter(function ($activity) use ($teacherClub) {
            return (int)$activity->club_id === (int)$teacherClub->id; // cast to int for proper comparison
        });

        Log::info('Student Activities:', [
            'student_id' => $student->id,
            'activities' => $clubActivities->toArray(), // changed to log proper array
        ]);

        
        $positionId = $student->clubs
            ->where('id', $teacherClub->id)
            ->first()
            ?->pivot
            ?->club_position_id;
        $position = $positionId ? ClubPosition::find($positionId) : null;  

        // Compute teacher-club specific scores:
        $teacherClubActivities = $student->activities->filter(function ($activity) use ($teacherClub) {
            return $activity->club_id === $teacherClub->id;
        });
        $teacherActivity = $teacherClubActivities->first();
        $involvementScoreForTeacher = 0;
        $placementScoreForTeacher = 0;
        if ($teacherActivity && $teacherActivity->achievement) {
            if ($teacherActivity->placement_id) {
                $placementScoreForTeacher = $teacherActivity->achievement->placements()
                    ->where('placement_id', $teacherActivity->placement_id)
                    ->first()?->pivot->score ?? 0;
            }
            $involvementScoreForTeacher = $teacherActivity->achievement->involvements()
                    ->where('involvement_type_id', $teacherActivity->involvement_id)
                    ->first()?->pivot->score ?? 0;
        }
        // Call the new function to get highest scores
        $highestScores = $this->getHighestScores($teacherClubActivities);

        return view('pajsk.evaluate', [
            'student'                       => $student,
            'club'                          => $teacherClub,
            'position'                      => $position,
            'attendanceScores'              => Attendance::all(),
            'commitments'                   => Commitment::all(),
            'serviceContributions'          => ServiceContribution::all(),
            'involvementScore'              => $involvementScoreForTeacher,
            'placementScore'                => $placementScoreForTeacher,
            'teacher'                       => $teacher,
            'clubActivities'                => $clubActivities,
            'highestPlacementScore'         => $highestScores['highestPlacementScore'],
            'highestAchievementScore'       => $highestScores['highestAchievementScore'],
            'highestPlacementId'            => $highestScores['highestPlacementId'],
            'highestPlacementActivityId'    => $highestScores['highestPlacementActivityId'],
            'highestAchievementId'          => $highestScores['highestAchievementId'],
            'highestAchievementActivityId'  => $highestScores['highestAchievementActivityId'],
            'placementString'               => $highestScores['placementString'],
            'achievementString'             => $highestScores['achievementString'],
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
            'attendance_id' => 'required|exists:attendances,id',
            'position_id' => 'nullable|exists:club_positions,id',
            'achievement_id' => 'nullable|exists:achievements,id',
            'achievement_activity_id' => 'nullable|exists:activities,id',
            'placement_id' => 'nullable|exists:placements,id',
            'placement_activity_id' => 'nullable|exists:activities,id',
            'commitment_ids' => 'required|json',
            'service_id' => 'required|exists:service_contributions,id',
        ]);

        // Parse JSON for commitments
        $commitmentIds = json_decode($validated['commitment_ids'], true);

        // Get records for score calculation
        $attendanceRecord = Attendance::findOrFail($validated['attendance_id']);
        $serviceContribution = ServiceContribution::findOrFail($validated['service_id']);
        $clubPosition = $validated['position_id'] ? ClubPosition::find($validated['position_id']) : null;
        
        // Calculate scores
        $attendancePoint = $attendanceRecord->score;
        $clubPositionPoint = $clubPosition ? $clubPosition->point : 0;
        $commitmentScore = Commitment::whereIn('id', $commitmentIds)->sum('score');
        $serviceScore = $serviceContribution->score;

        // Get achievement/placement scores
        $achievementScore = 0;
        $placementScore = 0;
        if ($validated['achievement_id']) {
            $achievement = Achievement::find($validated['achievement_id']);
            if ($achievement) {
                $achievementScore = $achievement->involvements()
                    ->where('involvement_type_id', Activity::find($validated['achievement_activity_id'])?->involvement_id)
                    ->first()?->pivot->score ?? 0;
            }
        }
        if ($validated['placement_id']) {
            $placement = Placement::find($validated['placement_id']);
            if ($placement) {
                $placementScore = $placement->achievements()
                    ->where('achievement_id', Activity::find($validated['placement_activity_id'])?->achievement_id)
                    ->first()?->pivot->score ?? 0;
            }
        }

        $totalScore = $attendancePoint + $clubPositionPoint + $achievementScore + $placementScore + $commitmentScore + $serviceScore;
        $percentage = round(($totalScore / 110) * 100, 2);

        // Determine teacher's club category index
        $sukan = ['Sukan & Permainan', 'Sukan'];
        $kelab = ['Kelab & Persatuan', 'Kelab & Persatuan', 'Kelab & Permainan']; // note: duplicate not harmful
        $badan = ['Badan Beruniform'];
        $teacher = Auth::user()->teacher;
        $teacherClub = $teacher->club;
        if (!$teacherClub) {
            abort(403, 'Teacher has no registered club.');
        }
        if (in_array($teacherClub->category, $sukan)) {
            $index = 0;
        } elseif (in_array($teacherClub->category, $kelab)) {
            $index = 1;
        } elseif (in_array($teacherClub->category, $badan)) {
            $index = 2;
        } else {
            $index = null;
        }
        if ($index === null) {
            abort(500, 'Teacher club category is undefined.');
        }
        
        // Initialize arrays with 3 items each.
        $defaultNull = [null, null, null];
        $defaultEmptyArray = [[], [], []];
        
        // For club_ids, collect student's clubs by category.
        // For each category index, find the student's club in that category.
        $clubsByCategory = [$defaultNull[0], $defaultNull[1], $defaultNull[2]];
        foreach ($student->clubs as $club) {
            if (in_array($club->category, $sukan)) {
                $clubsByCategory[0] = $club->id;
            } elseif (in_array($club->category, $kelab)) {
                $clubsByCategory[1] = $club->id;
            } elseif (in_array($club->category, $badan)) {
                $clubsByCategory[2] = $club->id;
            }
        }
        
        // Get or create assessment
        $assessment = PajskAssessment::firstOrNew([
            'student_id' => $student->id,
            'class_id' => $student->classroom->id,
        ]);

        // Initialize arrays
        $defaultNull = [null, null, null];
        $defaultEmptyArray = [[], [], []];

        // Set all assessment fields
        $assessment->teacher_ids = $assessment->teacher_ids ?? $defaultNull;
        $assessment->club_ids = $clubsByCategory;
        $assessment->club_position_ids = $assessment->club_position_ids ?? $defaultNull;
        $assessment->service_contribution_ids = $assessment->service_contribution_ids ?? $defaultNull;
        $assessment->attendance_ids = $assessment->attendance_ids ?? $defaultNull;
        $assessment->commitment_ids = $assessment->commitment_ids ?? $defaultEmptyArray;
        $assessment->service_contribution_ids = $assessment->service_contribution_ids ?? $defaultNull;
        $assessment->achievement_ids = $assessment->achievement_ids ?? $defaultNull;
        $assessment->achievements_activity_ids = $assessment->achievements_activity_ids ?? $defaultNull;
        $assessment->placement_ids = $assessment->placement_ids ?? $defaultNull;
        $assessment->placements_activity_ids = $assessment->placements_activity_ids ?? $defaultNull;
        $assessment->total_scores = $assessment->total_scores ?? $defaultNull;
        $assessment->percentages = $assessment->percentages ?? $defaultNull;

        // Update arrays with new values
        $temp = $assessment->teacher_ids;
        $temp[$index] = $teacher->id;
        $assessment->teacher_ids = $temp;

        $temp = $assessment->attendance_ids;
        $temp[$index] = $validated['attendance_id'];
        $assessment->attendance_ids = $temp;

        $temp = $assessment->club_position_ids;
        $temp[$index] = $validated['position_id'];
        $assessment->club_position_ids = $temp;

        $temp = $assessment->achievement_ids;
        $temp[$index] = $validated['achievement_id'];
        $assessment->achievement_ids = $temp;

        $temp = $assessment->achievements_activity_ids;
        $temp[$index] = $validated['achievement_activity_id'];
        $assessment->achievements_activity_ids = $temp;

        $temp = $assessment->placement_ids;
        $temp[$index] = $validated['placement_id'];
        $assessment->placement_ids = $temp;

        $temp = $assessment->placements_activity_ids;
        $temp[$index] = $validated['placement_activity_id'];
        $assessment->placements_activity_ids = $temp;

        $temp = $assessment->commitment_ids;
        $temp[$index] = $commitmentIds;
        $assessment->commitment_ids = $temp;

        $temp = $assessment->service_contribution_ids;
        $temp[$index] = $validated['service_id'];
        $assessment->service_contribution_ids = $temp;

        $temp = $assessment->total_scores;
        $temp[$index] = $totalScore;
        $assessment->total_scores = $temp;

        $temp = $assessment->percentages;
        $temp[$index] = $percentage;
        $assessment->percentages = $temp;

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
        $totalScores  = $evaluation->total_scores ?? [];  
        $percentages  = $evaluation->percentages ?? [];
        $commitmentIds = $evaluation->commitment_ids ?? [];

        $scores = [
            'attendance' => [
                'ids' => $evaluation->attendance_ids,
                'scores' => array_map(function($id) {
                    $att = Attendance::find($id);
                    return $att ? $att->score : 0;
                }, $evaluation->attendance_ids ?? []),
                'counts' => array_map(function($id) {
                    $att = Attendance::find($id);
                    return $att ? $att->attendance_count : 0;
                }, $evaluation->attendance_ids ?? []),
            ],
            'clubs' => [
                'ids' => $evaluation->club_ids,
                'names' => array_map(function($id) {
                    $club = Club::find($id);
                    return $club ? $club->club_name : '';
                }, $evaluation->club_ids ?? []),
            ],
            'club_positions' => [
                'ids' => $evaluation->club_position_ids,
                'scores' => array_map(function($id) {
                    $cp = ClubPosition::find($id);
                    return $cp ? $cp->point : 0;
                }, $evaluation->club_position_ids ?? []),
                'names' => array_map(function($id) {
                    $cp = ClubPosition::find($id);
                    return $cp ? $cp->position_name : '';
                }, $evaluation->club_position_ids ?? []),
            ],
            'service_contributions' => [
                'ids' => $evaluation->service_contribution_ids,
                'scores' => array_map(function($id) {
                    $serv = ServiceContribution::find($id);
                    return $serv ? $serv->score : 0;
                }, $evaluation->service_contribution_ids ?? []),
                'names' => array_map(function($id) {
                    $serv = ServiceContribution::find($id);
                    return $serv ? $serv->service_name : '';
                }, $evaluation->service_contribution_ids ?? []),
            ],
            'commitments' => [
                'ids' => $evaluation->commitment_ids,
                'scores' => array_map(function($idArray) {
                    $scores = array_map(function($id) {
                        $comm = Commitment::find($id);
                        return $comm ? $comm->score : 0;
                    }, $idArray);
                    return [array_sum($scores)];
                }, $evaluation->commitment_ids ?? []),
                'names' => array_map(function ($idArray) {
                    return array_map(function ($id) {
                        $commitment = Commitment::find($id);
                        return $commitment ? $commitment->commitment_name : null;
                    }, $idArray);
                }, $commitmentIds),
            ],
            // Added placement scores
            'placement' => [
                'ids' => $evaluation->placement_ids,
                'scores' => array_map(function($id, $achievementId) {
                    if (!$id || !$achievementId) return 0;
                    return DB::table('achievement_placement')
                        ->where('placement_id', $id)
                        ->where('achievement_id', $achievementId)
                        ->value('score') ?? 0;
                }, $evaluation->placement_ids ?? [], $evaluation->achievement_ids ?? []),
            ],
            // Added achievement scores
            'achievement' => [
                'ids' => $evaluation->achievement_ids,
                'scores' => array_map(function($id) {
                    $achievement = Achievement::find($id);
                    return $achievement ? ($achievement->involvements()->first()->pivot->score ?? 0) : 0;;
                }, $evaluation->achievement_ids ?? []),
            ],
            'achievement_strings' => array_map(function($i) use ($evaluation) {
                $activityData = Activity::where('id', $evaluation->achievements_activity_ids[$i] ?? null)->first();
                $represent = $activityData ? $activityData->represent : 'N/A';
                $involvementName = ($activityData && $activityData->involvement) ? ($activityData->involvement->description ?? 'N/A') : 'N/A';
                $club = Club::find($evaluation->club_ids[$i] ?? null);
                $clubName = $club ? $club->club_name : 'N/A';
                $achievement = Achievement::find($evaluation->achievement_ids[$i] ?? null);
                $placement = Placement::find($evaluation->placement_ids[$i] ?? null);
                $achievementName = $achievement ? $achievement->achievement_name : 'N/A';
                $placementName = $placement ? $placement->placement_name : 'N/A';
                return "{$represent} {$involvementName} {$clubName} Peringkat {$achievementName}";
            }, range(0, count($evaluation->club_ids) - 1)),
            'placement_strings' => array_map(function($p) use ($evaluation) {
                $activityData = Activity::where('id', $evaluation->placements_activity_ids[$p] ?? null)->first();
                $represent = $activityData ? $activityData->represent : 'N/A';
                $involvementName = ($activityData && $activityData->involvement) ? ($activityData->involvement->description ?? 'N/A') : 'N/A';
                $club = Club::find($evaluation->club_ids[$p] ?? null);
                $clubName = $club ? $club->club_name : 'N/A';
                $achievement = Achievement::find($evaluation->achievement_ids[$p] ?? null);
                $achievementName = $achievement ? $achievement->achievement_name : 'N/A';
                $placement = Placement::find($evaluation->placement_ids[$p] ?? null);
                $placementName = $placement ? $placement->name : 'N/A';
                return "{$represent} {$involvementName} {$clubName}, {$placementName} Peringkat {$achievementName}";
            }, range(0, count($evaluation->club_ids) - 1)),
        ];

        Log::info('Scores:', [
            'student_id' => $student->id,
            'scores' => $scores,
        ]);

        $service = ServiceContribution::find(optional($evaluation->service_contribution_ids)[0]);

        $result = [
            'scores'                => $scores,
            'totalScores'           => $totalScores,
            'percentages'           => $percentages,
            'student'               => $student,
            'teacher_ids'           => $evaluation->teacher_ids,
            'year'                  => $evaluation->classroom->year,
            'class_name'            => $evaluation->classroom->class_name,
            'club_ids'              => $evaluation->club_ids,
            'position'              => optional($evaluation->club_positions->first())->position_name,
            'attendance'            => $attendance,
            'service'               => $service,
            'assessment'            => $evaluation,
            'extracocuricullum'     => $extracocuricullum,
            'involvement_ids'       => $evaluation->involvement_ids,
            'placement_ids'         => $evaluation->placement_ids,
            'achievement_ids'       => $evaluation->achievement_ids,
            'activity_ids'          => $evaluation->activity_ids,
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
        $previousYear = $assessment->classroom->year > 1 ? $assessment->classroom->year - 1 : $assessment->classroom->year;
        // Log::info('Generating report for student:', [
        //     'student_id' => $student->id,
        //     'previous_year' => $previousYear,
        // ]);
        $oldAssessment = PajskReport::where('student_id', $student->id)
            ->whereHas('classroom', function ($q) use ($previousYear) {
                $q->where('year', $previousYear);
            })->latest()->first();
        $cgpaLast = $oldAssessment ? $oldAssessment->cgpa : null;

        // Log::info('Previous Year Assessment:', [
        //     'student_id' => $student->id,
        //     'previous_year' => $previousYear,
        //     'old_assessment' => $oldAssessment,
        //     'cgpa_last' => $cgpaLast,
        // ]);

        // Calculate GPA from the total_scores array
        $scores = $assessment->total_scores ?? [];
        rsort($scores);
        if (count($scores) >= 2) {
            $gpa = ($scores[0] + $scores[1]) / 2;
        } elseif (count($scores) == 1) {
            $gpa = $scores[0];
        } else {
            $gpa = 0;
        }

        if ($assessment->classroom->year > 1) {
            $cgpa = ($gpa + $cgpaLast) / 2;
        } else {
            $cgpa = $gpa;
        }

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
            'cgpa_last' => $cgpaLast,
            'cgpa_pctg' => $cgpa_pctg,
            'report_description' => $report_description,
        ]);
        
        // Change the route name to match the registered route: 'pajsk.show-report'
        return redirect()->route('pajsk.show-report', ['student' => $student->id, 'report' => $report->id]);
    }

    public function reportHistory(Request $request)
    {
        $search = $request->get('search');
        $year_filter = $request->get('year_filter');
        $class_filter = $request->get('class_filter');

        $query = PajskReport::with(['student.user', 'classroom']);

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
            $query->whereHas('classroom', function($q) use ($year_filter) {
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

        $reports = $query->latest()->paginate(10);
        
        return view('pajsk.report-history', [
            'reports' => $reports,
            'classNames' => $classNames
        ]);
    }

    public function showReport(Student $student, PajskReport $report)
    {
        if ($report->student_id !== $student->id) {
            abort(404, 'Report not found for the given student.');
        }
        $assessment = PajskAssessment::find($report->pajsk_assessment_id);
        $extracocuricullum = ExtraCocuricullum::find($report->extra_cocuricullum_id);

        // Get the previous year's CGPA
        $previousYear = $report->classroom->year > 1 ? $report->classroom->year - 1 : $report->classroom->year;
        $oldAssessment = PajskReport::where('student_id', $student->id)
            ->whereHas('classroom', function ($q) use ($previousYear) {
                $q->where('year', $previousYear);
            })->latest()->first();
        $cgpaLast = $oldAssessment ? $oldAssessment->cgpa : null;
        
        // Group clubs and related scores by club category
        $groupedClubs = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];
        $groupedPositions = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];
        $groupedCommitmentNames = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];
        $groupedServiceNames = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];
        $groupedAttendanceCounts = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];
        
        // Add new grouped arrays
        $groupedAchievementNames = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];

        $groupedPlacementNames = [
            'Sukan / Permainan' => '--',
            'Kelab / Persatuan' => '--',
            'Badan Beruniform'  => '--',
        ];

        // Initialize score arrays separately
        $groupedPositionScores = $groupedCommitmentScores = $groupedServiceScores = 
        $groupedAttendanceScores = $groupedPlacementScores = $groupedAchievementScores = [
            'Sukan / Permainan' => 0,
            'Kelab / Persatuan' => 0,
            'Badan Beruniform'  => 0,
        ];

        if (!empty($assessment->club_ids)) {
            foreach($assessment->club_ids as $i => $clubId) {
                $club = Club::find($clubId);
                if(!$club) continue;
                if (in_array($club->category, ['Sukan & Permainan','Sukan'])) {
                    $group = 'Sukan / Permainan';
                } elseif (in_array($club->category, ['Kelab & Persatuan','Kelab & Permainan'])) {
                    $group = 'Kelab / Persatuan';
                } elseif ($club->category == 'Badan Beruniform') {
                    $group = 'Badan Beruniform';
                } else {
                    $group = null;
                }
                if ($group) {
                    $groupedClubs[$group] = $club->club_name;

                    if (isset($assessment->club_position_ids[$i])) {
                        $position = ClubPosition::find($assessment->club_position_ids[$i]);
                        $groupedPositions[$group] = $position?->position_name ?? '--';
                        $groupedPositionScores[$group] = $position?->point ?? 0;
                    }

                    // Add commitment scores
                    if (isset($assessment->commitment_ids[$i]) && !empty($assessment->commitment_ids[$i])) {
                        $commitments = collect($assessment->commitment_ids[$i])->filter();
                        $groupedCommitmentNames[$group] = $commitments->map(function($id) {
                            return Commitment::find($id)?->commitment_name ?? '--';
                        })->implode(', ');
                        $groupedCommitmentScores[$group] = $commitments->sum(function($id) {
                            return Commitment::find($id)?->score ?? 0;
                        });
                    }

                    // Add service scores
                    if (isset($assessment->service_contribution_ids[$i])) {
                        $service = ServiceContribution::find($assessment->service_contribution_ids[$i]);
                        $groupedServiceNames[$group] = $service?->service_name ?? '--';
                        $groupedServiceScores[$group] = $service?->score ?? 0;
                    }

                    // Add attendance scores 
                    if (isset($assessment->attendance_ids[$i])) {
                        $attendance = Attendance::find($assessment->attendance_ids[$i]);
                        $groupedAttendanceCounts[$group] = $attendance?->attendance_count . ' days' ?? '--';
                        $groupedAttendanceScores[$group] = $attendance?->score ?? 0;
                    }

                    // Add placement scores
                    if (isset($assessment->placement_ids[$i])) {
                        $placement = Placement::find($assessment->placement_ids[$i]);
                        $groupedPlacementNames[$group] = $placement?->name ?? '--';
                        $groupedPlacementScores[$group] = $placement?->achievements()->first()?->pivot->score ?? 0;
                    }

                    // Add achievement scores
                    if (isset($assessment->achievement_ids[$i])) {
                        $achievement = Achievement::find($assessment->achievement_ids[$i]);
                        $groupedAchievementNames[$group] = $achievement?->achievement_name ?? '--';
                        $groupedAchievementScores[$group] = $achievement?->involvements()->first()?->pivot->score ?? 0;
                    }

                }
            }
        }

        $result = [
            // 'year'                      => $assessment->classroom->year,
            // 'class_name'                => $assessment->classroom->class_name,
            'cgpaLast'                  => $cgpaLast,
            'student'                   => $student,
            'report'                    => $report,
            'totalScores'               => $assessment->total_scores ?? [],
            'percentages'               => $assessment->percentages ?? [],
            'teacher_ids'               => $assessment->teacher_ids,
            'club_ids'                  => $assessment->club_ids,
            'groupedClubs'              => $groupedClubs,
            'groupedPositions'          => $groupedPositions,
            'groupedPositionScores'     => $groupedPositionScores,
            'groupedCommitmentNames'    => $groupedCommitmentNames,
            'groupedCommitmentScores'   => $groupedCommitmentScores,
            'groupedServiceNames'       => $groupedServiceNames,
            'groupedServiceScores'      => $groupedServiceScores,
            'groupedAttendanceCounts'   => $groupedAttendanceCounts,
            'groupedAttendanceScores'   => $groupedAttendanceScores,
            'groupedAchievementNames'   => $groupedAchievementNames,
            'groupedAchievementScores'  => $groupedAchievementScores,
            'groupedPlacementNames'     => $groupedPlacementNames,
            'groupedPlacementScores'    => $groupedPlacementScores,
            'extracocuricullum'         => $extracocuricullum,
        ];
        
        return view('pajsk.report', $result);
    }

    public function destroyReport(PajskReport $report)
    {
        $report->delete();
        return redirect()->route('pajsk.report-history')->with('success', 'Report deleted successfully.');
    }

    // Add this new private function near the bottom of the class
    private function getHighestScores($activities): array
    {
        Log::debug('Starting getHighestScores function with ' . count($activities) . ' activities');
        
        if (count($activities) == 0) {
            Log::debug('No activities found, returning null values');
            return [
                'highestPlacementScore'         => null,
                'highestAchievementScore'       => null,
                'highestPlacementId'            => null,
                'highestAchievementId'          => null,
                'highestAchievementActivityId'  => null,
                'highestPlacementActivityId'    => null,
                'achievementString'             => 'No achievement.',
                'placementString'               => 'No placement.',
            ];
        }

        $highestPlacementScore = 0;
        $highestAchievementScore = 0;
        $highestPlacementId = null;
        $highestPlacementActivityId = null;
        $highestAchievementId = null;
        $highestAchievementActivityId = null;
        
        Log::debug('Initial values set: placement score = 0, achievement score = 0');
        
        foreach ($activities as $activity) {
            Log::debug('Processing activity ID: ' . $activity->id);
            
            if (!$activity->achievement) {
                Log::debug('Activity ' . $activity->id . ' has no achievement, skipping');
                continue;
            }
            
            $currentPlacementId = null;
            $currentAchievementId = null;
            $currentPlacementActivityId = null;
            $currentAchievementActivityId = null;
            $currentPlacementScore = null;
            $currentAchievementScore = null;
            
            if ($activity->placement_id) {
                Log::debug('Activity ' . $activity->id . ' has placement_id: ' . $activity->placement_id);
                $currentPlacementScore = $activity->achievement->placements()
                    ->where('placement_id', $activity->placement_id)
                    ->first()?->pivot->score ?? null;
                $currentPlacementId = $activity->placement_id;
                $currentPlacementActivityId = $activity->id;
                Log::debug('Placement score: ' . $currentPlacementScore);
            }
            
            if ($activity->achievement_id) {
                Log::debug('Activity ' . $activity->id . ' has achievement_id: ' . $activity->achievement_id);
                $currentAchievementScore = $activity->achievement->involvements()
                ->where('achievement_id', $activity->achievement_id)
                ->first()?->pivot->score ?? null;
                $currentAchievementId = $activity->achievement_id;
                $currentAchievementActivityId = $activity->id;
                Log::debug('Achievement score: ' . $currentAchievementScore);
            }
            
            if ($currentPlacementScore > $highestPlacementScore) {
                Log::debug('New highest placement score found: ' . $currentPlacementScore . ' (previous: ' . $highestPlacementScore . ')');
                $highestPlacementScore = $currentPlacementScore ?? 0;
                $highestPlacementId = $currentPlacementId;
                $highestPlacementActivityId = $currentPlacementActivityId;
            } else {
                $highestPlacementScore = $currentPlacementScore;
                $highestPlacementId = $currentPlacementId;
                $highestPlacementActivityId = $currentPlacementActivityId;
            }
            
            if ($currentAchievementScore > $highestAchievementScore) {
                Log::debug('New highest achievement score found: ' . $currentAchievementScore . ' (previous: ' . $highestAchievementScore . ')');
                $highestAchievementScore = $currentAchievementScore ?? 0;
                $highestAchievementId = $currentAchievementId;
                $highestAchievementActivityId = $currentAchievementActivityId;
            } else {
                $highestAchievementScore = $currentAchievementScore;
                $highestAchievementId = $currentAchievementId;
                $highestAchievementActivityId = $currentAchievementActivityId;
                
            }
        }
        
        Log::debug('Final highest placement score: ' . $highestPlacementScore . ' (ID: ' . $highestPlacementId . ', Activity ID: ' . $highestPlacementActivityId . ')');
        Log::debug('Final highest achievement score: ' . $highestAchievementScore . ' (ID: ' . $highestAchievementId . ', Activity ID: ' . $highestAchievementActivityId . ')');

        if ($highestAchievementId != null) {
            $achievementData = Activity::where('id', $activity->id ?? null)->first();
            Log::debug('Achievement data retrieved for ID: ' . $activity->id);
            $represent = $achievementData ? $achievementData->represent : 'N/A';
            $involvementName = ($achievementData && $achievementData->involvement) ? ($achievementData->involvement->description ?? 'N/A') : 'N/A';
            $club = Club::find($activity->club_id ?? null);
            $clubName = $club ? $club->club_name : 'N/A';
            $achievement = Achievement::find($activity->achievement_id ?? null);
            $achievementName = $achievement ? $achievement->achievement_name : 'N/A';
            $placement = Placement::find($activity->placement_id ?? null);
            $placementName = $placement ? $placement->name : 'N/A';
            $achievementString = "{$represent} {$involvementName} {$clubName} Peringkat {$achievementName}";
        } else {
            $achievementString = "No achievement.";
        };

        if ($highestPlacementId != null) {
            $placementData = Activity::where('id', $activity->id ?? null)->first();
            Log::debug('Placement data retrieved for ID: ' . $activity->id);
            $represent = $placementData ? $placementData->represent : 'N/A';
            $involvementName = ($placementData && $placementData->involvement) ? ($placementData->involvement->description ?? 'N/A') : 'N/A';
            $club = Club::find($activity->club_id ?? null);
            $clubName = $club ? $club->club_name : 'N/A';
            $achievement = Achievement::find($activity->achievement_id ?? null);
            $achievementName = $achievement ? $achievement->achievement_name : 'N/A';
            $placement = Placement::find($activity->placement_id ?? null);
            $placementName = $placement ? $placement->name : 'N/A';
            $placementString = "{$represent} {$involvementName} {$clubName}, {$placementName} Peringkat {$achievementName}";
        } else {
            $placementString = "No placement.";
        }

        Log::debug($placementString);
        Log::debug($achievementString);

        
        return [
            'highestPlacementScore'         => $highestPlacementScore ?? 0,
            'highestAchievementScore'       => $highestAchievementScore ?? 0,
            'highestPlacementId'            => $highestPlacementId ?? null,
            'highestAchievementId'          => $highestAchievementId ?? null,
            'highestAchievementActivityId'  => $highestAchievementActivityId ?? null,
            'highestPlacementActivityId'    => $highestPlacementActivityId ?? null,
            'achievementString'             => $achievementString,
            'placementString'               => $placementString,
        ];
    }
}
