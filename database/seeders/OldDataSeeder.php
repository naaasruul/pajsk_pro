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
use App\Models\Placement;
use App\Models\TimmsAndPisa;
use Log;
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
        
        // Get available service contribution ids (as string values)
        $serviceContributions = ServiceContribution::all();
        $serviceIdsAvailable = $serviceContributions->pluck('id')->map(fn($id) => (string)$id)->toArray();
        // Get available attendance record ids
        $attendanceIdsPool = Attendance::pluck('id')->toArray();
        // Get available commitment ids (as strings)
        $commitmentIdsPool = Commitment::pluck('id')->map(fn($id) => (string)$id)->toArray();
        
        // Helper function to get club category index
        $getCategoryIndex = function($category) {
            switch ($category) {
                case 'Sukan & Permainan':
                    return 0;
                case 'Kelab & Persatuan':
                    return 1;
                case 'Badan Beruniform':
                    return 2;
                default:
                    return null;
            }
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
                
            $totalPoint = min($totalPoint, 10);
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

        // Loop through each student to create pajsk_assessments data.
        foreach ($students as $student) {
            $studentClass = Classroom::find($student->class_id);
            $maxYear = $studentClass->year;
            
            // For each unique classroom year (1 .. current year), create one assessment.
            for ($year = 1; $year <= $maxYear; $year++) {
                if ($year < $maxYear) {
                    $classroom = Classroom::where('year', $year)->inRandomOrder()->first();
                    $class_id = $classroom ? $classroom->id : $student->classroom->id;
                } else {
                    $class_id = $student->classroom->id;
                }
                
                // // Initialize arrays with 3 elements (for 3 categories)
                // $n = rand(1, 3); // Randomly choose how many categories to fill (1 to 3)
                
                // Initialize all arrays with nulls for proper indexing
                $studentClubIds = array_fill(0, 3, null);
                $teacherIds = array_fill(0, 3, null);
                $serviceContribIds = array_fill(0, 3, null);
                $attendanceIds = array_fill(0, 3, null);
                $studentClubPositions = array_fill(0, 3, null);
                $serviceIds = array_fill(0, 3, null);
                $commitmentIds = array_fill(0, 3, []);
                $achievementIds = array_fill(0, 3, null);
                $achievementActivityIds = array_fill(0, 3, null);
                $placementIds = array_fill(0, 3, null);
                $placementActivityIds = array_fill(0, 3, null);
                $totals = array_fill(0, 3, 0);
                $percents = array_fill(0, 3, 0);

                // Map student's clubs to correct category indices
                foreach ($student->clubs as $club) {
                    $categoryIndex = $getCategoryIndex($club->category);
                    if ($categoryIndex !== null) {
                        $studentClubIds[$categoryIndex] = $club->id;
                    }
                }

                // Prepare pools for random selection
                $teacherArr = $teachers->pluck('id')->toArray();
                $serviceContribArr = $serviceContributions->pluck('id')->map(fn($id) => (string)$id)->toArray();
                $attendanceArr = $attendanceIdsPool;
                $positionArr = ClubPosition::all()->pluck('id')->toArray();

                // Fill arrays at each index where we have a club
                for ($i = 0; $i < 3; $i++) {
                    if ($studentClubIds[$i] !== null) {
                        // Assign random values for this category index
                        $teacherIds[$i] = $teacherArr[array_rand($teacherArr)];
                        $serviceContribIds[$i] = $serviceContribArr[array_rand($serviceContribArr)];
                        $serviceIds[$i] = $serviceContribIds[$i]; // Same as service contribution
                        $attendanceIds[$i] = $attendanceArr[array_rand($attendanceArr)];
                        $studentClubPositions[$i] = $positionArr[array_rand($positionArr)];
                        
                        // Generate 4 random commitment IDs for this index
                        $randomCommitments = [];
                        for ($j = 0; $j < 4; $j++) {
                            $randomCommitments[] = $commitmentIdsPool[array_rand($commitmentIdsPool)];
                        }
                        $commitmentIds[$i] = $randomCommitments;
                    }
                }

                // Get activities for clubs stored in studentClubIds array
                for ($i = 0; $i < 3; $i++) {
                    if ($studentClubIds[$i] !== null) {
                        // First try to get activity for the specific club where student participates
                        $activity = Activity::where('club_id', $studentClubIds[$i])
                            ->whereRaw('JSON_CONTAINS(activity_students_id, ?)', ['"'.$student->id.'"'])
                            ->with(['achievement', 'achievement.involvements', 'achievement.placements'])
                            ->orderBy('id', 'desc')
                            ->first();

                        // If no activity found with student participation, get any activity from the club
                        if (!$activity) {
                            $activity = Activity::where('club_id', $studentClubIds[$i])
                                ->with(['achievement', 'achievement.involvements', 'achievement.placements'])
                                ->orderBy('id', 'desc')
                                ->first();
                        }

                        // If still no activity, create a fallback or use any available activity
                        if (!$activity) {
                            $activity = Activity::with(['achievement', 'achievement.involvements', 'achievement.placements'])
                                ->inRandomOrder()
                                ->first();
                        }

                        if ($activity) {
                            // Store activity at the same index as the club
                            $achievementActivityIds[$i] = $activity->id;
                            
                            // Handle achievement if exists
                            if ($activity->achievement) {
                                $achievementIds[$i] = $activity->achievement->id;
                                
                                // Handle placements
                                if ($activity->achievement->placements && $activity->achievement->placements->isNotEmpty()) {
                                    $placementIds[$i] = $activity->achievement->placements->first()->id;
                                    $placementActivityIds[$i] = $activity->id;
                                }
                            }
                            
                            // Ensure student is attached to this activity
                            if (!$student->activities()->where('activity_id', $activity->id)->exists()) {
                                $student->activities()->attach($activity->id);
                            }
                        }
                    }
                }

                // Calculate scores for each category index
                for ($k = 0; $k < 3; $k++) {
                    if ($studentClubIds[$k] !== null) {
                        // Basic scores
                        $attScore = $attendanceIds[$k] ? (Attendance::find($attendanceIds[$k])?->score ?? rand(30, 40)) : 0;
                        $posScore = $studentClubPositions[$k] ? (ClubPosition::find($studentClubPositions[$k])?->point ?? rand(1, 10)) : 0;
                        $involScore = 0;
                        $placeScore = 0;
                        
                        // Achievement involvement score
                        if ($achievementIds[$k] && $achievementActivityIds[$k]) {
                            $activity = Activity::find($achievementActivityIds[$k]);
                            if ($activity && $activity->achievement) {
                                $involvement = $activity->achievement->involvements->first();
                                $involScore = $involvement ? ($involvement->pivot->score ?? 0) : 0;
                            }
                        }
                        
                        // Placement score
                        if ($placementIds[$k] && $achievementIds[$k]) {
                            // Get activity and its achievement
                            $activity = Activity::find($achievementActivityIds[$k]);
                            if ($activity && $activity->achievement) {
                                // Get placement score from pivot table
                                $placeScore = DB::table('achievement_placement')
                                    ->where([
                                        'placement_id' => $placementIds[$k],
                                        'achievement_id' => $activity->achievement->id
                                    ])
                                    ->value('score') ?? 0;

                                Log::debug("Placement score for activity {$activity->id}, placement {$placementIds[$k]}, achievement {$activity->achievement->id}: {$placeScore}");
                            }
                        }

                        // Commitment scores
                        $commScore = 0;
                        if (!empty($commitmentIds[$k])) {
                            foreach ($commitmentIds[$k] as $cid) {
                                $commScore += Commitment::find($cid)?->score ?? rand(1, 4);
                            }
                        }
                        
                        // Service score
                        $servScore = $serviceContribIds[$k] ? 
                            (ServiceContribution::find($serviceContribIds[$k])?->score ?? rand(5, 10)) : 0;
                        
                        // Calculate total and percentage
                        $totals[$k] = $attScore + $posScore + $involScore + $commScore + $servScore + $placeScore;
                        $percents[$k] = round(($totals[$k] / 110) * 100, 2);
                    }
                }

                // Create assessment with category-indexed arrays
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