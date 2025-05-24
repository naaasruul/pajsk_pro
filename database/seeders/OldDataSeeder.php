<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Club;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\ClubPosition;
use App\Models\Commitment;
use App\Models\PajskAssessment;
use App\Models\ExtraCocuricullum;
use App\Models\Teacher;
use App\Models\ServiceContribution;
use App\Models\Services;
use App\Models\SpecialAward;
use App\Models\CommunityServices;
use App\Models\Nilam;
use App\Models\TimmsAndPisa;
use Illuminate\Support\Facades\DB;

class OldDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder now creates multiple assessment rows per student following the new storage schema.
     */
    public function run(): void
    {
        // Call other seeder classes to seed classrooms, students, clubs, club_student pivot and activities.
        $this->call([
            ClassroomSeeder::class,
            StudentSeeder::class,
            // ClubSeeder::class,
            ClubStudentSeeder::class,
            ActivitySeeder::class,
        ]);

        $teachers = Teacher::all();
        $clubs = Club::all();
        $students = Student::all();
        // // Retrieve a seeded activity to use its involvement_id and placement_id
        // $seededActivity = Activity::inRandomOrder()->first();
        // $involvementIdFromActivity = $seededActivity ? $seededActivity->involvement_id : null;
        // $placementIdFromActivity   = $seededActivity ? $seededActivity->placement_id : null;
        // Get available service contribution ids (as string values)
        $serviceContributions = ServiceContribution::all();
        $serviceIdsAvailable = $serviceContributions->pluck('id')->map(fn($id) => (string)$id)->toArray();
        // Get available attendance record ids
        $attendanceIdsPool = Attendance::pluck('id')->toArray();
        // Get available commitment ids (as strings)
        $commitmentIdsPool = Commitment::pluck('id')->map(fn($id) => (string)$id)->toArray();
        
        // Helper function to ensure an array $n has exactly $n elements.
        $ensureLength = function(array $arr, int $n) {
            if(count($arr) < $n) {
                // pad by repeating random elements
                while(count($arr) < $n) {
                    $arr[] = $arr[array_rand($arr)];
                }
            } elseif(count($arr) > $n) {
                $arr = array_slice($arr, 0, $n);
            }
            return $arr;
        };

        // Also seed extra cocuricullum data for each student
        foreach ($students as $student) {
            $service = Services::inRandomOrder()->first();
            $specialAward = SpecialAward::inRandomOrder()->first();
            $communityService = CommunityServices::inRandomOrder()->first();
            $nilam = Nilam::inRandomOrder()->first();
            $timmsPisa = TimmsAndPisa::inRandomOrder()->first();
            $totalPoint = ($service->point ?? 0)
                + ($specialAward->point ?? 0)
                + ($communityService->point ?? 0)
                + ($nilam->point ?? 0)
                + ($timmsPisa->point ?? 0);
            ExtraCocuricullum::updateOrCreate(
                ['student_id' => $student->id, 'class_id' => $student->class_id],
                [
                    'service_id'           => $service->id ?? null,
                    'special_award_id'     => $specialAward->id ?? null,
                    'community_service_id' => $communityService->id ?? null,
                    'nilam_id'             => $nilam->id ?? null,
                    'timms_pisa_id'        => $timmsPisa->id ?? null,
                    'total_point'          => $totalPoint,
                ]
            );
        }
        // // Attach seeded activity to each student if not already attached
        // if ($seededActivity) {
        //     foreach ($students as $student) {
        //         if (!$student->activities()->where('activity_id', $seededActivity->id)->exists()) {
        //             $student->activities()->attach($seededActivity->id);
        //         }
        //     }
        // }

        // Loop through each student to create pajsk_assessments data.
        foreach ($students as $student) {
            $studentClass = Classroom::find($student->class_id);
            $maxYear = $studentClass->year;
            // Get student's clubs (as IDs)
            $studentClubIds = $ensureLength($student->clubs->pluck('id')->toArray(), 3);
            
            // For each unique classroom year (1 .. current year), create one assessment.
            // Loop over each unique classroom year so that a student has one assessment per year.
            for ($year = 1; $year <= $maxYear; $year++) {
                if ($year < $maxYear) {
                    $classroom = Classroom::where('year', $year)->inRandomOrder()->first();
                    $class_id = $classroom ? $classroom->id : $student->classroom->id;
                } else {
                    $class_id = $student->classroom->id;
                }
                
                // Determine random item quantity (0-3) for each evaluation array
                // $n = rand(0, 3);
                // DEBUG: Force n to always be 3 for testing
                $n = 3;

                // Select $n distinct teacher IDs.
                $teacherArr = $teachers->pluck('id')->toArray();
                shuffle($teacherArr);
                $teacherIds = array_slice($teacherArr, 0, $n);
                
                // Select $n distinct service contribution IDs (as strings).
                $serviceContribArr = $serviceContributions->pluck('id')->map(fn($id) => (string)$id)->toArray();
                shuffle($serviceContribArr);
                $serviceContribIds = array_slice($serviceContribArr, 0, $n);
                
                // Select $n distinct attendance IDs.
                $attendanceArr = $attendanceIdsPool;
                shuffle($attendanceArr);
                $attendanceIds = array_slice($attendanceArr, 0, $n);
                
                // Select $n distinct club position IDs.
                $positionArr = ClubPosition::all()->pluck('id')->toArray();
                shuffle($positionArr);
                $studentClubPositions = array_slice($positionArr, 0, $n);
                
                // Use distinct service IDs same as service contribution IDs.
                $serviceIds = $serviceContribIds;

                // For commitments, build a 2D array with $n nested arrays, each with 4 random commitment ids.
                $commitmentIds = [];
                for ($j = 0; $j < $n; $j++) {
                    $commitmentIds[] = (array) array_rand(array_flip($commitmentIdsPool), 4);
                }

                // For each student, get random activities with achievements
                $activities = $student->activities()
                    ->with(['achievement.involvements', 'achievement.placements'])
                    ->get()
                    ->filter(fn($act) => $act->achievement)
                    ->values();

                // Get activities for each club where student is a participant
                $studentActivities = Activity::whereRaw('JSON_CONTAINS(activity_students_id, ?)', ['"'.$student->id.'"'])
                    ->whereHas('achievement')
                    ->with(['achievement.involvements', 'achievement.placements', 'club'])
                    ->get();

                // Get student's clubs grouped by category
                $clubsByCategory = [
                    'Sukan' => $student->clubs->where('category', 'like', '%Sukan%')->first()?->id,
                    'Kelab' => $student->clubs->where('category', 'like', '%Kelab%')->first()?->id,
                    'Badan' => $student->clubs->whereIn('category', ['Badan Beruniform'])->first()?->id,
                ];

                // Order student's clubs by category type [Kelab, Sukan, Badan]
                $orderedClubIds = [null, null, null];
                foreach ($student->clubs as $club) {
                    if (in_array($club->category, ['Sukan & Permainan'])) {
                        $orderedClubIds[0] = $club->id; // Sukan first
                    } elseif (in_array($club->category, ['Kelab & Persatuan'])) {
                        $orderedClubIds[1] = $club->id; // Kelab second
                    } elseif ($club->category === 'Badan Beruniform') {
                        $orderedClubIds[2] = $club->id; // Badan third
                    }
                }

                // Filter out nulls and ensure exactly 3 elements
                $studentClubIds = array_values(array_filter($orderedClubIds));
                $studentClubIds = $ensureLength($studentClubIds, 3);

                // Initialize arrays matching club order
                $achievementIds = array_fill(0, 3, null);
                $achievementActivityIds = array_fill(0, 3, null);
                $placementIds = array_fill(0, 3, null);
                $placementActivityIds = array_fill(0, 3, null);

                // Get all relevant activities for student and these specific clubs
                $relevantActivities = Activity::whereIn('club_id', $studentClubIds)
                    ->whereRaw('JSON_CONTAINS(activity_students_id, ?)', ['"'.$student->id.'"'])
                    ->whereHas('achievement')
                    ->with(['achievement.placements'])
                    ->get()
                    ->groupBy('club_id');

                // Match activities to club positions
                foreach ($studentClubIds as $index => $clubId) {
                    $clubActivities = $relevantActivities->get($clubId, collect());
                    
                    if ($clubActivities->isNotEmpty()) {
                        // Get best activity for this club
                        $bestActivity = $clubActivities->sortByDesc(function($activity) {
                            return $activity->achievement->placements->sum('pivot.score');
                        })->first();

                        if ($bestActivity && $bestActivity->achievement) {
                            $achievementIds[$index] = $bestActivity->achievement->id;
                            $achievementActivityIds[$index] = $bestActivity->id;

                            if ($bestActivity->achievement->placements->isNotEmpty()) {
                                $placementIds[$index] = $bestActivity->achievement->placements->first()->id;
                                $placementActivityIds[$index] = $bestActivity->id;
                            }
                        }
                    }
                }

                // If no activities found for a club, use null values
                while (count($achievementIds) < count($studentClubIds)) {
                    $achievementIds[] = null;
                    $achievementActivityIds[] = null;
                    $placementIds[] = null;
                    $placementActivityIds[] = null;
                }

                // No need to pad arrays - we want exact matches with clubs

                // Initialize arrays with correct sizes and null values
                $totals = array_fill(0, $n, 0);
                $percents = array_fill(0, $n, 0);

                for ($k = 0; $k < $n; $k++) {
                    // Basic scores init
                    $attScore = Attendance::find($attendanceIds[$k])?->score ?? rand(30, 40);
                    $posScore = ClubPosition::find($studentClubPositions[$k])?->point ?? rand(1, 10);
                    $involScore = 0;
                    $placeScore = 0;
                    
                    // Handle activity data for this index if available
                    if ($activities->isNotEmpty()) {
                        $activityForOrg = $activities->random();
                        
                        // Achievement handling
                        if ($activityForOrg->achievement) {
                            $achievementIds[$k] = $activityForOrg->achievement->id;
                            $achievementActivityIds[$k] = $activityForOrg->id;
                            
                            // Get involvement score
                            $involvement = $activityForOrg->achievement->involvements->first();
                            $involScore = $involvement ? ($involvement->pivot->score ?? 0) : 0;
                            
                            // Get placement score
                            $placement = $activityForOrg->achievement->placements->first();
                            if ($placement) {
                                $placementIds[$k] = $placement->id;
                                $placementActivityIds[$k] = $activityForOrg->id;
                                $placeScore = $placement->pivot->score ?? 0;
                            }
                        }
                    }

                    // Calculate commitment scores
                    $commScore = isset($commitmentIds[$k]) ? array_sum(array_map(function($cid) {
                        return Commitment::find($cid)?->score ?? rand(1, 4);
                    }, $commitmentIds[$k])) : 0;
                    
                    // Service score
                    $servScore = isset($serviceContribIds[$k]) ? 
                        (ServiceContribution::find($serviceContribIds[$k])?->score ?? rand(5, 10)) : 0;
                    
                    // Calculate total and percentage
                    $totals[$k] = $attScore + $posScore + $involScore + $commScore + $servScore + $placeScore;
                    $percents[$k] = round(($totals[$k] / 110) * 100, 2);
                }

                // Create assessment with filled arrays
                PajskAssessment::create([
                    'student_id' => $student->id,
                    'class_id' => $class_id,
                    'teacher_ids' => $teacherIds,
                    'club_ids' => $studentClubIds,
                    'club_position_ids' => $studentClubPositions,
                    'service_contribution_ids' => $serviceContribIds,
                    'attendance_ids' => $attendanceIds,
                    'commitment_ids' => $commitmentIds,
                    'achievement_ids' => $achievementIds,
                    'achievements_activity_ids' => $achievementActivityIds,
                    'placement_ids' => $placementIds,
                    'placements_activity_ids' => $placementActivityIds,
                    'total_scores' => $totals,
                    'percentages' => $percents,
                ]);

                // Attach any new activities to student if needed
                foreach ($achievementActivityIds as $activityId) {
                    if ($activityId && !$student->activities()->where('activity_id', $activityId)->exists()) {
                        $student->activities()->attach($activityId);
                    }
                }
            }
        }

        // Output a console message to indicate that the seeding process has completed successfully.
        $this->command->info('Old data seeded successfully.');
    }
}
