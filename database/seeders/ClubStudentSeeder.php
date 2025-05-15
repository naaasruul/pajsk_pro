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
		// Retrieve all clubs and group them by category needed
		$persatuanClubs = Club::where('category', 'Kelab & Persatuan')->get();
		$sukanClubs = Club::where('category', 'Sukan & Permainan')->get();
		$beruniformClubs = Club::where('category', 'Badan Beruniform')->get();

		$students = Student::all();
		$positions = ClubPosition::all();
		$defaultPosition = $positions->where('position_name', 'Ahli Biasa')->first();

		foreach ($students as $student) {
			// For each category, pick one club randomly (if available)
			$selectedClubs = [];
			if ($persatuanClubs->isNotEmpty()) {
				$selectedClubs[] = $persatuanClubs->random();
			}
			if ($sukanClubs->isNotEmpty()) {
				$selectedClubs[] = $sukanClubs->random();
			}
			if ($beruniformClubs->isNotEmpty()) {
				$selectedClubs[] = $beruniformClubs->random();
			}

			foreach ($selectedClubs as $club) {
				// 20% chance to get a leadership position; otherwise, use default
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

		$this->command->info('Each student has been assigned to three clubs (one per category) successfully');
	}
}
