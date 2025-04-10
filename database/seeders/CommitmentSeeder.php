<?php

namespace Database\Seeders;

use App\Models\Commitment;
use Illuminate\Database\Seeder;

class ClubPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commitments = [
            ['commitment_name' => 'Menunjukkan Kepimpinan', 'score' => 3],
            ['commitment_name' => 'Mengurus Aktiviti', 'score' => 3],
            ['commitment_name' => 'Membantu guru atau rakan', 'score' => 2],
            ['commitment_name' => 'Menyedia Peralatan', 'score' => 2],
            ['commitment_name' => 'Mengemas Peralatan', 'score' => 2],
        ];

        foreach ($commitments as $commitment); {
            Commitment::create($commitment);
        }
    }
}
