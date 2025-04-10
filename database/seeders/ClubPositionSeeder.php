<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClubPosition;

class ClubPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['position_name' => 'Pengerusi', 'point' => 10],
            ['position_name' => 'Naib Pengerusi', 'point' => 8],
            ['position_name' => 'Penolong Setiausaha', 'point' => 5],
            ['position_name' => 'Ahli Biasa', 'point' => 4],
            ['position_name' => 'Ahli Berdaftar', 'point' => 2],
        ];

        foreach ($positions as $position) {
            ClubPosition::create($position);
        }
    }
}
