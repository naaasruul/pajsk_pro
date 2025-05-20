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
            ['club_name' => 'Kelab Muzik', 'category' => 'Kelab & Persatuan'],                  // id: 1
            ['club_name' => 'Kelab Sukan', 'category' => 'Sukan & Permainan'],                  // id: 2
            ['club_name' => 'Kadet Polis', 'category' => 'Badan Beruniform'],                   // id: 3

            ['club_name' => 'Kelab Alam Sekitar', 'category' => 'Kelab & Persatuan'],           // id: 4
            ['club_name' => 'Kelab Komputer', 'category' => 'Kelab & Persatuan'],               // id: 5
            ['club_name' => 'Kelab Seni Lukis', 'category' => 'Kelab & Persatuan'],             // id: 6
            ['club_name' => 'Kelab Bahasa Inggeris', 'category' => 'Kelab & Persatuan'],        // id: 7
            ['club_name' => 'Kelab Matematik', 'category' => 'Kelab & Persatuan'],              // id: 8
            ['club_name' => 'Kadet Bomba', 'category' => 'Badan Beruniform'],                   // id: 9
            ['club_name' => 'Pandu Puteri', 'category' => 'Badan Beruniform'],                  // id: 10
            ['club_name' => 'Pengakap', 'category' => 'Badan Beruniform'],                      // id: 11
            ['club_name' => 'PBSM', 'category' => 'Badan Beruniform'],                          // id: 12
            ['club_name' => 'Puteri Islam', 'category' => 'Badan Beruniform'],                  // id: 13
            ['club_name' => 'TKRS', 'category' => 'Badan Beruniform'],                          // id: 14
        ];

        foreach ($clubs as $club) {
            Club::create($club);
        }
    }
}
