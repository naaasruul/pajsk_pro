<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nilam;

class NilamSeeder extends Seeder
{
    public function run()
    {
        $this->call(TierSeeder::class);

        $nilams = [
            ['achievement_id' => 1, 'tier_id' => 1, 'point' => 10],
            ['achievement_id' => 1, 'tier_id' => 2, 'point' => 8],
            ['achievement_id' => 2, 'tier_id' => 1, 'point' => 9],
            ['achievement_id' => 2, 'tier_id' => 3, 'point' => 7],
        ];

        foreach ($nilams as $nilam) {
            Nilam::create($nilam);
        }
    }
}