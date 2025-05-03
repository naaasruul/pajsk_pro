<?php

namespace Database\Seeders;

use App\Models\CommunityServices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraCocuCommunityServices extends Seeder
{
   /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Community Service 1', 'point' => 5],
            ['name' => 'Community Service 2', 'point' => 8],
            ['name' => 'Community Service 3', 'point' => 10],
        ];

        foreach ($services as $service) {
            CommunityServices::create($service);
        }
    }
}
