<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            ['club_name' => 'Kelab Alam Sekitar', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kelab Komputer', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kelab Seni Lukis', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kelab Bahasa Inggeris', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kelab Matematik', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kelab Sukan', 'category' => 'Sukan & Permainan'],
            // ['club_name' => 'Kelab Muzik', 'category' => 'Kelab & Persatuan'],
            // ['club_name' => 'Kadet Polis', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'Kadet Bomba', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'Pandu Puteri', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'Pengakap', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'PBSM', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'Puteri Islam', 'category' => 'Badan Beruniform'],
            // ['club_name' => 'TKRS', 'category' => 'Badan Beruniform'],
        ];

        foreach ($clubs as $club) {
            Club::create($club);
        }
    }
}
