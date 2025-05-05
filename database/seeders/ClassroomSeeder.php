<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use Faker\Factory as Faker;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Create 10 classrooms with random data
        for ($i = 1; $i <= 10; $i++) {
            Classroom::create([
                'year' => $faker->numberBetween(1, 6),  // Random academic year
                'class_name' => $faker->randomElement(['Taubat', 'Muhibbah', 'Zuhud', 'Ikhlas', 'Tawakkal', 'Sabar']),
                'active_status' => $faker->boolean ? 1 : 0,
            ]);
        }
    }
}
