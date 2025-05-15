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
        
        // Helper function to ensure an array has exactly $n elements.
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
            $service = \App\Models\Services::inRandomOrder()->first();
            $specialAward = \App\Models\SpecialAward::inRandomOrder()->first();
            $communityService = \App\Models\CommunityServices::inRandomOrder()->first();
            $nilam = \App\Models\Nilam::inRandomOrder()->first();
            $timmsPisa = \App\Models\TimmsAndPisa::inRandomOrder()->first();
            $totalPoint = ($service->point ?? 0)
                        + ($specialAward->point ?? 0)
                        + ($communityService->point ?? 0)
                        + ($nilam->point ?? 0)
                        + ($timmsPisa->point ?? 0);
            \App\Models\ExtraCocuricullum::updateOrCreate(
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
                
                // Select 3 distinct teacher IDs.
                $teacherArr = $teachers->pluck('id')->toArray();
                shuffle($teacherArr);
                $teacherIds = array_slice($teacherArr, 0, 3);
                
                // Select 3 distinct service contribution IDs (as strings).
                $serviceContribArr = $serviceContributions->pluck('id')->map(fn($id)=>(string)$id)->toArray();
                shuffle($serviceContribArr);
                $serviceContribIds = array_slice($serviceContribArr, 0, 3);
                
                // Select 3 distinct attendance IDs.
                $attendanceArr = $attendanceIdsPool;
                shuffle($attendanceArr);
                $attendanceIds = array_slice($attendanceArr, 0, 3);
                
                // Select 3 distinct club position IDs.
                $positionArr = \App\Models\ClubPosition::all()->pluck('id')->toArray();
                shuffle($positionArr);
                $studentClubPositions = array_slice($positionArr, 0, 3);
                
                // Use distinct service IDs same as service contribution IDs.
                $serviceIds = $serviceContribIds;

                // For commitments, build a 2D array with 3 nested arrays, each with 4 random commitment ids.
                $commitmentIds = [];
                for ($j = 0; $j < 3; $j++) {
                    $commitmentIds[] = (array) array_rand(array_flip($commitmentIdsPool), 4);
                }

                // For scores, here we simulate per-organization (3 clubs)
                $totals = [];
                $percents = [];
                for ($k = 0; $k < 3; $k++) {
                    // Simulate individual score components (you can replace with more elaborate logic)
                    $attScore = Attendance::find($attendanceIds[$k])?->score ?? rand(30, 40);
                    $posScore = ClubPosition::find($studentClubPositions[$k])?->point ?? rand(1,10);
                    // Use model relationships to determine true involvement and placement scores:
                    $activities = $student->activities()->with(['achievement.involvements','achievement.placements'])->get();
                    if($activities->isNotEmpty()){
                        $activityForOrg = $activities->random();
                        $involScore = optional($activityForOrg->achievement->involvements->first())->pivot->score ?? 0;
                        $placeScore = optional($activityForOrg->achievement->placements->first())->pivot->score ?? 0;
                    } else {
                        $involScore = 0;
                        $placeScore = 0;
                    }
                    // Sum commitment scores for 4 commitments in this organization.
                    $commScore = 0;
                    foreach ($commitmentIds[$k] as $cid) {
                        $commScore += Commitment::find($cid)?->score ?? rand(1, 4);
                    }
                    $servScore = ServiceContribution::find($serviceIds[$k])?->score ?? rand(5,10);
                    $total = $attScore + $posScore + $involScore + $commScore + $servScore + $placeScore;
                    $totals[] = $total;
                    $percents[] = round(($total/110)*100,2);
                    \Illuminate\Support\Facades\Log::info('Pajsk Assessment Calculation', [
                        'org_index' => $k,
                        'attendanceScore' => $attScore,
                        'positionScore' => $posScore,
                        'involvementScore' => $involScore,
                        'commitmentScore' => $commScore,
                        'serviceScore' => $servScore,
                        'placementScore' => $placeScore,
                        'total' => $total,
                        'percentage' => round(($total/110)*100,2)
                    ]);
                }
                
                // Select a random activity for this assessment.
                $randomActivity = Activity::inRandomOrder()->first();
                $involvementId = $randomActivity ? $randomActivity->involvement_id : null;
                $placementId   = $randomActivity ? $randomActivity->placement_id : null;
                
                PajskAssessment::create([
                    'student_id' => $student->id,
                    'class_id'   => $class_id,
                    'teacher_ids' => $teacherIds,
                    'club_ids' => $studentClubIds,
                    'club_position_ids' => $studentClubPositions,
                    'service_contribution_ids' => $serviceContribIds,
                    'attendance_ids' => $attendanceIds,
                    'commitment_ids' => $commitmentIds,
                    'involvement_id' => $involvementId,
                    'placement_id' => $placementId,
                    'service_ids' => $serviceIds,
                    'total_scores' => $totals,
                    'percentages' => $percents,
                ]);
                // Attach the randomly selected activity if not already attached
                if ($randomActivity && !$student->activities()->where('activity_id', $randomActivity->id)->exists()) {
                    $student->activities()->attach($randomActivity->id);
                }
            }
        }

        // Output a console message to indicate that the seeding process has completed successfully.
        $this->command->info('Old data seeded successfully.');
    }
}
