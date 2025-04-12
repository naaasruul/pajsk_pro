<?php

namespace Database\Seeders;

use App\Models\Placement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placements = [
            ['name' => 'Johan'],
            ['name' => 'Naib Johan'],
            ['name' => 'Ketiga'],
            ['name' => 'Keempat'],
            ['name' => 'Kelima'],
        ];

        foreach ($placements as $placement) {
            Placement::create($placement);
        }

        $this->command->info('Placement seeded successfully!');

    }
}
