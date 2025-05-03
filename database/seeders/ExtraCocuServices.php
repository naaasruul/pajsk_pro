<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraCocuServices extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Service 1', 'point' => 4],
            ['name' => 'Service 2', 'point' => 7],
            ['name' => 'Service 3', 'point' => 9],
        ];

        
        foreach ($services as $service) {
            Services::create($service);
        }
    }
}
