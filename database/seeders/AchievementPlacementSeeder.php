<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementPlacementSeeder extends Seeder
{
	public function run(): void
	{
		$scores = [
			// antarabangsa
			[1, 1, 20],
			[2, 1, 19],
			[3, 1, 18],

			// kebangsaan
			[1, 2, 17],
			[2, 2, 16],
			[3, 2, 15],

			// negeri
			[1, 3, 14],
			[2, 3, 13],
			[3, 3, 12],

			// bahagian
			[1, 4, 12],
			[2, 4, 11],
			[3, 4, 10],

			// zon/daerah
			[1, 5, 11],
			[2, 5, 10],
			[3, 5, 9],

			// sekolah
			[1, 6, 8],
			[2, 6, 7],
			[3, 6, 6],
			[4, 6, 5],
			[5, 6, 4],
		];

		foreach ($scores as $score) {
			DB::table('achievement_placement')->insert([
				'placement_id' => $score[0],
				'achievement_id' => $score[1],
				'score' => $score[2],
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}

		$this->command->info('Involvement scores seeded successfully');
	}
}
