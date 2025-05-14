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
     * This method seeds classrooms, students, clubs, club-student records,
     * activities, PAJSK assessments and extra co-curricular data.
     * 
     * IMPORTANT: REVERT BY USING OldDataAntiSeeder
     */
    public function run(): void
    {
        // Call other seeder classes to seed classrooms, students, clubs, club_student pivot and activities.
        $this->call([
            ClassroomSeeder::class,
            StudentSeeder::class,
            ClubSeeder::class,
            ClubStudentSeeder::class,
            ActivitySeeder::class,
        ]);

        // Retrieve all teacher records from the teacher table.
        $teachers = Teacher::all();
        // Retrieve all club records from the club table.
        $clubs = Club::all();

        // Retrieve all student records from the student table.
        $students = Student::all();

        // Loop through each student to create assessment and extracurricular data.
        foreach ($students as $student) {
            // Retrieve the classroom record for the current student using the student's class_id.
            $studentClass = Classroom::find($student->class_id);
            // Set the maximum number of academic years based on the classroom's year.
            $maxYear = $studentClass->year;

            // Iterate over each academic year for the student.
            for ($year = 1; $year <= $maxYear; $year++) {
                // Select a random attendance record from the Attendance table.
                $attendance = Attendance::inRandomOrder()->first();
                // Read the attendance score; if not found, default to 0.
                $attendanceScore = $attendance ? $attendance->score : 0;
                
                // Select four random commitment records from the Commitment table.
                $commitments = Commitment::inRandomOrder()->take(4)->get();
                // Collect the IDs of the selected commitment records.
                $commitmentIds = $commitments->pluck('id')->toArray();
                // Sum the score values of the selected commitment records.
                $commitmentScore = $commitments->sum('score');
                
                // Query the ServiceContribution table for the record with the service name 'ATLET/PESERTA'.
                $serviceContribution = ServiceContribution::where('service_name', 'ATLET/PESERTA')->first();
                // Define the service score from the found record, or default to 0.
                $serviceScore = $serviceContribution ? $serviceContribution->score : 0;
                
                // Retrieve the first available record from the Activity table.
                $activity = Activity::first();
                
                // Determine the club position ID; if the activity does not define it,
                // retrieve the ID for the position named 'Ahli Biasa'.
                $clubPositionId = $activity->club_position_id ?: ClubPosition::where('position_name', 'Ahli Biasa')->value('id');
                // Retrieve the point value associated with the determined club position.
                $positionScore = ClubPosition::where('id', $clubPositionId)->value('point');
                
                // Retrieve the involvement score from the achievement_involvement table using the activity's achievement_id and involvement_id.
                $involvementScore = DB::table('achievement_involvement')
                    ->where('achievement_id', $activity->achievement_id)
                    ->where('involvement_type_id', $activity->involvement_id)
                    ->value('score') ?? 5;
                    
                // Retrieve the placement score using the achievement_placement table, based on the activity's achievement_id and placement_id.
                $placementScore = DB::table('achievement_placement')
                    ->where('achievement_id', $activity->achievement_id)
                    ->where('placement_id', $activity->placement_id)
                    ->value('score') ?? 0;
                
                // Compute the total score as the sum of attendance, position, involvement, commitment, service, and placement scores.
                $totalScore = $attendanceScore + $positionScore + $involvementScore + $commitmentScore + $serviceScore + $placementScore;
                // Compute the percentage based on the total score out of a base value of 110.
                $percentage = ($totalScore / 110) * 100;

                // Select a random teacher record to associate with the assessment.
                $teacher = $teachers->random();
                // Select a random club record to associate with the assessment.
                $club    = $clubs->random();
                
                // Create a new PAJSK assessment record with all of the computed values and identifiers.
                PajskAssessment::create([
                    'student_id'        => $student->id,                       // Link the assessment to the student.
                    'class_id'          => $student->class_id,                 // Link the assessment to the student's class.
                    'teacher_id'        => $teacher->id,                       // Record the teacher's ID.
                    'club_id'           => $club->id,                          // Record the club's ID.
                    'club_position_id'  => $clubPositionId,                    // Record the club position ID.
                    'attendance_score'  => $attendanceScore,                   // Set the attendance score.
                    'position_score'    => $positionScore,                     // Set the score corresponding to the club position.
                    'involvement_score' => $involvementScore,                  // Set the involvement score.
                    'commitment_score'  => $commitmentScore,                   // Set the commitment score.
                    'service_score'     => $serviceScore,                      // Set the service score for contributions.
                    'placement_score'   => $placementScore,                    // Set the placement score.
                    'total_score'       => $totalScore,                        // Set the computed total score.
                    'percentage'        => $percentage,                        // Set the computed percentage.
                    'commitment_ids'    => $commitmentIds,                     // Save the list of commitment IDs.
                    'service_contribution_id' => $serviceContribution ? $serviceContribution->id : 0, // Save the service contribution record ID or 0 if none.
                ]);

                // Retrieve a random Services record for extra co-curricular data.
                $service = Services::inRandomOrder()->first();
                // Retrieve a random SpecialAward record.
                $specialAward = SpecialAward::inRandomOrder()->first();
                // Retrieve a random CommunityServices record.
                $communityService = CommunityServices::inRandomOrder()->first();
                // Retrieve a random Nilam record.
                $nilam = Nilam::inRandomOrder()->first();
                // Retrieve a random TimmsAndPisa record.
                $timmsPisa = TimmsAndPisa::inRandomOrder()->first();
                // Compute the overall total point from the points of the selected extra co-curricular records.
                $totalPoint = $service->point + $specialAward->point + $communityService->point + $nilam->point + $timmsPisa->point;

                // Create an ExtraCocuricullum record with the associated extra co-curricular data.
                ExtraCocuricullum::create([
                    'student_id'         => $student->id,                   // Link to the student.
                    'class_id'           => $student->class_id,             // Link to the student's class.
                    'service_id'         => $service ? $service->id : null,   // Save the service record ID if available.
                    'special_award_id'   => $specialAward ? $specialAward->id : null, // Save the special award record ID if available.
                    'community_service_id' => $communityService ? $communityService->id : null, // Save the community service record ID if available.
                    'nilam_id'           => $nilam ? $nilam->id : null,       // Save the Nilam record ID if available.
                    'timms_pisa_id'      => $timmsPisa ? $timmsPisa->id : null, // Save the Timms and PISA record ID if available.
                    'total_point'        => $totalPoint,                    // Save the computed extra co-curricular total points.
                ]);
            }
            // Retrieve a dummy activity record to ensure the student has associated activity data.
            $dummyActivity = Activity::first();
            // If a dummy activity exists, attach it to the student's activity relationships without detaching existing ones.
            if ($dummyActivity) {
                $student->activities()->syncWithoutDetaching([$dummyActivity->id]);
            }
        }

        // Output a console message to indicate that the seeding process has completed successfully.
        $this->command->info('Old data seeded successfully');
    }
}
