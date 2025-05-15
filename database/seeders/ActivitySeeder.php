<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Placement;
use App\Models\InvolvementType;
use App\Models\Achievement;
use App\Models\Club;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if related tables have data
        if (Placement::count() === 0) {
            $this->command->warn('No data found in the "placements" table. Please insert data before running this seeder.');
            return;
        }

        if (InvolvementType::count() === 0) {
            $this->command->warn('No data found in the "involvement_types" table. Please insert data before running this seeder.');
            return;
        }

        if (Achievement::count() === 0) {
            $this->command->warn('No data found in the "achievements" table. Please insert data before running this seeder.');
            return;
        }

        if (Club::count() === 0) {
            $this->command->warn('No data found in the "clubs" table. Please insert data before running this seeder.');
            return;
        }

        if (Teacher::count() === 0) {
            $this->command->warn('No data found in the "teachers" table. Please insert data before running this seeder.');
            return;
        }
        
        for ($i = 0; $i < 5; $i++) {
            // Fetch IDs from related tables
            $placementId = Placement::inRandomOrder()->first()->id;
            $involvementId = InvolvementType::inRandomOrder()->first()->id;
            $achievementId = Achievement::inRandomOrder()->first()->id;
            $clubId = Club::inRandomOrder()->first()->id;
            $leaderId = Teacher::inRandomOrder()->first()->id;
            $createdBy = Teacher::inRandomOrder()->first()->id;

            // Fetch random teachers and students IDs
            $randomTeacherIds = Teacher::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $randomStudentIds = Student::inRandomOrder()->limit(3)->pluck('id')->toArray();

            // Add Faker instance
            $faker = \Faker\Factory::create();

            // Create a new activity
            Activity::create([
                'represent' => 'Menghadiri',
                'placement_id' => $placementId,
                'involvement_id' => $involvementId,
                'achievement_id' => $achievementId,
                'club_id' => $clubId,
                'category' => 'Kelab & Persatuan',
                'activity_place' => $faker->city(),
                'date_start' => $faker->date(),
                'time_start' => $faker->time(),
                'date_end' => $faker->date(),
                'time_end' => $faker->time(),  
                'leader_id' => $leaderId,
                'created_by' => $createdBy,
                'activity_teachers_id' => json_encode($randomTeacherIds),
                'activity_students_id' => json_encode($randomStudentIds) 
            ]);
        }

        $this->command->info('Activity seeded successfully!');
    }
}