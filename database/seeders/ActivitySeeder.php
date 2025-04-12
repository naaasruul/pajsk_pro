<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Placement;
use App\Models\InvolvementType;
use App\Models\Achievement;
use App\Models\Club;
use App\Models\Teacher;
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

        // Fetch IDs from related tables
        $placementId = Placement::first()->id;
        $involvementId = InvolvementType::first()->id;
        $achievementId = Achievement::first()->id;
        $clubId = Club::first()->id;
        $leaderId = Teacher::first()->id;
        $createdBy = Teacher::first()->id;

        // Seed example activity
        Activity::create([
            'represent' => 'Menghadiri',
            'placement_id' => $placementId,
            'involvement_id' => $involvementId,
            'achievement_id' => $achievementId,
            'club_id' => $clubId,
            'category' => 'Kelab & Persatuan',
            'activity_place' => 'Padang Jawa',
            'date_start' => '2025-01-01',
            'time_start' => '10:00',
            'date_end' => '2025-01-02',
            'time_end' => '12:00',
            'leader_id' => $leaderId,
            'created_by' => $createdBy,
        ]);

        $this->command->info('Activity seeded successfully!');
    }
}