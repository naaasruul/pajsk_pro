<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use DB;
class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            'Antarabangsa', 'Kebangsaan', 'Negeri',
            'Bahagian (Sabah/Sarawak)', 'Zon/Daerah', 'Sekolah',
        ];

        foreach ($stages as $stage) {
            DB::table('achievements')->insert([
                'achievement_name' => $stage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Achievements seeded successfully!');
    }
}