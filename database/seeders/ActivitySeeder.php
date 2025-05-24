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
        
        // Create activities for each club ensuring proper distribution
        $clubs = Club::with('students')->get()->groupBy('category');
        
        foreach ($clubs as $category => $categoryClubs) {
            foreach ($categoryClubs as $club) {
                // Create 3-5 activities per club to ensure enough data
                $numActivities = rand(3, 5);
                
                for ($i = 0; $i < $numActivities; $i++) {
                    // Get random achievement with involvement and placement
                    $achievement = Achievement::with(['involvements', 'placements'])->inRandomOrder()->first();
                    
                    // Ensure we have students from this club
                    $clubStudentIds = $club->students()
                        ->select('students.id')
                        ->inRandomOrder()
                        ->limit(10)
                        ->pluck('id')
                        ->toArray();

                    if (empty($clubStudentIds)) continue;

                    // Get club teachers plus one random teacher
                    $clubTeacherIds = $club->teachers()
                        ->select('teachers.id')
                        ->inRandomOrder()
                        ->limit(2)
                        ->pluck('id')
                        ->toArray();

                    $leader = $club->teachers()->inRandomOrder()->first();
                    $leaderId = $leader ? $leader->id : Teacher::inRandomOrder()->first()->id;

                    $activity = Activity::create([
                        'represent' => 'Menghadiri',
                        'placement_id' => $achievement->placements->first()?->id,
                        'involvement_id' => $achievement->involvements->first()?->id,
                        'achievement_id' => $achievement->id,
                        'club_id' => $club->id,
                        'category' => $club->category,
                        'activity_place' => \Faker\Factory::create()->city,
                        'date_start' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                        'time_start' => '08:00:00',
                        'date_end' => now()->format('Y-m-d'),
                        'time_end' => '17:00:00',
                        'leader_id' => $leaderId,
                        'created_by' => $leaderId,
                        'activity_teachers_id' => json_encode($clubTeacherIds),
                        'activity_students_id' => json_encode($clubStudentIds)
                    ]);

                    // Attach students and teachers
                    foreach ($clubStudentIds as $studentId) {
                        if (!$activity->students()->where('student_id', $studentId)->exists()) {
                            $activity->students()->attach($studentId);
                        }
                    }
                }
            }
        }

        $this->command->info('Activities seeded successfully with proper category distribution!');
    }
}