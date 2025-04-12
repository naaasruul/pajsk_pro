<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed example achievements
        Achievement::create([
            'achievement_name' => 'Anugerah Cemerlang',
        ]);

        Achievement::create([
            'achievement_name' => 'Juara Sukan',
        ]);

        Achievement::create([
            'achievement_name' => 'Penyertaan Aktif',
        ]);

        Achievement::create([
            'achievement_name' => 'Kepimpinan Terbaik',
        ]);

        $this->command->info('Achievements seeded successfully!');
    }
}