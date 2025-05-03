<?php

namespace Database\Seeders;

use App\Models\TimmsAndPisa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraCocuTIMMS_PISA extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example data for TIMMS and PISA
        $data = [
            ['name' => 'TIMMS 2025', 'point' => 10],
            ['name' => 'PISA 2025', 'point' => 8],
        ];
        foreach ($data as $item) {
            TimmsAndPisa::create($item);
        }
    }
}
