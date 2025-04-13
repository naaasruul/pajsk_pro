<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementInvolvementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('achievement_involvement')->truncate();

        $scoreMatrix = [
            // [involvement_type, achievement_id, score]
            // Type 1 (Highest)
            [1, 1, 20], // International
            [1, 2, 18], // National
            [1, 3, 16], // State
            [1, 4, 14], // District
            [1, 5, 12], // School
            
            // Type 2 (Medium)
            [2, 1, 15],
            [2, 2, 13],
            [2, 3, 11],
            [2, 4, 9],
            [2, 5, 7],
            
            // Type 3 (Basic)
            [3, 1, 10],
            [3, 2, 8],
            [3, 3, 6],
            [3, 4, 4],
            [3, 5, 2],
        ];

        foreach ($scoreMatrix as [$type, $achievement, $score]) {
            DB::table('achievement_involvement')->insert([
                'involvement_type_id' => $type,
                'achievement_id' => $achievement,
                'score' => $score,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}