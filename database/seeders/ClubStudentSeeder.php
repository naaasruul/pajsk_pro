<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Student;
use App\Models\ClubPosition;
use Illuminate\Database\Seeder;

class ClubStudentSeeder extends Seeder
{
	public function run(): void
	{
		$clubs = Club::all();
		$students = Student::all();
		$positions = ClubPosition::all();
		$defaultPosition = $positions->where('position_name', 'Ahli Biasa')->first();

		// Assign each student to 1-2 random clubs
		foreach ($students as $student) {
			$numClubs = min(rand(1, 2), $clubs->count()); // cap it to available count
			$selectedClubs = $clubs->random($numClubs);

			foreach ($selectedClubs as $club) {
				// 20% chance to get a leadership position
				$position = rand(1, 100) <= 20
					? $positions->whereNotIn('position_name', ['Ahli Biasa', 'Ahli Berdaftar'])->random()
					: $defaultPosition;

				$student->clubs()->attach($club->id, [
					'club_position_id' => $position->id,
					'created_at' => now(),
					'updated_at' => now()
				]);
			}
		}

		$this->command->info('Students assigned to clubs successfully');
	}
}
