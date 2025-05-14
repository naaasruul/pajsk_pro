<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use Faker\Factory as Faker;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classes = ['Taubat', 'Muhibbah', 'Zuhud', 'Ikhlas', 'Tawakkal', 'Sabar'];
        foreach (range(1, 6) as $year) {
            foreach ($classes as $class) {
                Classroom::create([
                    'year' => $year,
                    'class_name' => $class,
                    'active_status' => 1,
                ]);
            }
        }
    }
}
