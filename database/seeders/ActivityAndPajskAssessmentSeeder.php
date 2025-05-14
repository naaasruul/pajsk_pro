<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\PajskAssessment;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Club;
use App\Models\ClubPosition;
use App\Models\ServiceContribution;
use Faker\Factory as Faker;

// DEPRECATED: This seeder is deprecated. Activity records will be seeded via OldDataSeeder class.

class ActivityAndPajskAssessmentSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create();

        // // Define arrays for foreign keys (using fixed arrays for some) 
        // $placementIds = [1, 2, 3, 4, 5];
        // $involvementIds = [1, 2, 3];
        // $achievementIds = [1, 2, 3, 4];
        // $clubIds = [1, 2, 3, 4, 5];
        // // Replace the hardcoded teacherIds array with a query that fetches valid teacher IDs from the teachers table
        // $teacherIds = \App\Models\Teacher::pluck('id')->toArray();
        // // We'll override student and related arrays with actual DB values:
        // $studentsDb = Student::pluck('id')->toArray();
        // if(empty($studentsDb)){
        //     $studentsDb = [1];
        // }
        // $classroomsDb = Classroom::pluck('id')->toArray();
        // if(empty($classroomsDb)){
        //     $classroomsDb = [1];
        // }
        // $teachersDb = Teacher::pluck('id')->toArray();
        // if(empty($teachersDb)){
        //     $teachersDb = [1];
        // }
        // $clubsDb = Club::pluck('id')->toArray();
        // if(empty($clubsDb)){
        //     $clubsDb = [1];
        // }
        // $clubPositionsDb = ClubPosition::pluck('id')->toArray();
        // if(empty($clubPositionsDb)){
        //     $clubPositionsDb = [1];
        // }
        // $serviceContributionsDb = ServiceContribution::pluck('id')->toArray();
        // if(empty($serviceContributionsDb)){
        //     $serviceContributionsDb = [1];
        // }
        // $statuses = ['pending', 'approved', 'rejected'];

        // // Seed 10 random Activity records
        // for ($i = 1; $i <= 10; $i++) {
        //     Activity::create([
        //         'represent'            => $faker->sentence(3),
        //         'placement_id'         => $faker->randomElement($placementIds),
        //         'involvement_id'       => $faker->randomElement($involvementIds),
        //         'achievement_id'       => $faker->randomElement($achievementIds),
        //         'club_id'              => $faker->randomElement($clubIds),
        //         'category'             => $faker->word,
        //         'activity_place'       => $faker->city,
        //         'date_start'           => $faker->date('Y-m-d', 'now'),
        //         'time_start'           => $faker->time('H:i:s'),
        //         'date_end'             => $faker->date('Y-m-d', 'now'),
        //         'time_end'             => $faker->time('H:i:s'),
        //         'activity_teachers_id' => json_encode($faker->randomElements($teacherIds, rand(1, count($teacherIds)))),
        //         'activity_students_id' => json_encode($faker->randomElements($studentsDb, min(rand(1, 3), count($studentsDb)))),
        //         // Fixed leader_id and created_by to a valid teacher (1)
        //         'leader_id'            => json_encode(1),
        //         'created_by'           => json_encode(1),
        //         'status'               => $faker->randomElement($statuses),
        //     ]);
        // }

        // deprecated, only activity records will be seeded, pajskassessment records will be seeded via OldDataSeeder class
        // uncomment from line 83 if pajsk assessment records are needed

        // // Seed 10 random PajskAssessment records
        // for ($i = 1; $i <= 10; $i++) {
        //     $attendance = $faker->randomElements([3.33, 6.66, 9.99, 13.32, 16.65, 19.98, 23.21, 26.64, 29.97, 33.30, 36.63, 40], 1)[0];
        //     $positionScore = $faker->randomElements([10, 8, 5, 4, 2], 1)[0];
        //     $involvementScore = $faker->numberBetween(1, 20);
        //     $placementScore = $faker->numberBetween(1, 20);
        //     $commitmentScore = $faker->numberBetween(1, 20);
        //     $serviceScore = $faker->numberBetween(1, 20);
        //     $achievementScore = $faker->numberBetween(1, 20);
        //     $totalScore = $faker->numberBetween(50, 110);

        //     PajskAssessment::create([
        //         'student_id'              => $faker->randomElement($studentsDb),
        //         'class_id'                => $faker->randomElement($classroomsDb),
        //         'teacher_id'              => $faker->randomElement($teachersDb),
        //         'club_id'                 => $faker->randomElement($clubsDb),
        //         'club_position_id'        => $faker->randomElement($clubPositionsDb),
        //         'attendance_score'        => $attendance,
        //         'position_score'          => $positionScore,
        //         'involvement_score'       => $involvementScore,
        //         'placement_score'         => $placementScore,
        //         'commitment_score'        => $commitmentScore,
        //         'service_score'           => $serviceScore,
        //         // 'achievement_score'       => $achievementScore,
        //         'total_score'             => $totalScore,
        //         'percentage'              => $faker->randomFloat(2, 0, 100),
        //         'commitment_ids'          => $faker->randomElements([1, 2, 3, 4, 5], 4),
        //         'service_contribution_id' => $faker->randomElement($serviceContributionsDb),
        //     ]);
        // }
    }
}
