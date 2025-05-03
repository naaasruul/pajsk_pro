<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecialAward;

class ExtraCocuSpecialAwards extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $awards = [
            ['name' => 'Special Award 1', 'point' => 6],
            ['name' => 'Special Award 2', 'point' => 8],
            ['name' => 'Special Award 3', 'point' => 10],
        ];

        foreach ($awards as $award) {
            SpecialAward::create($award);
        }
    }
}
