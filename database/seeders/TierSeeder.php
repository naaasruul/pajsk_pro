<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tier;

class TierSeeder extends Seeder
{
    public function run()
    {
        $tiers = [
            ['name' => 'Tier 1'],
            ['name' => 'Tier 2'],
            ['name' => 'Tier 3'],
        ];

        foreach ($tiers as $tier) {
            Tier::create($tier);
        }
    }
}