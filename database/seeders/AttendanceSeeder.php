<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendances = [
            ['attendance_count' => '1', 'score' => 3.33],
            ['attendance_count' => '2', 'score' => 6.66],
            ['attendance_count' => '3', 'score' => 9.99],
            ['attendance_count' => '4', 'score' => 13.32],
            ['attendance_count' => '5', 'score' => 16.65],
            ['attendance_count' => '6', 'score' => 19.98],
            ['attendance_count' => '7', 'score' => 23.21],
            ['attendance_count' => '8', 'score' => 26.64],
            ['attendance_count' => '9', 'score' => 29.97],
            ['attendance_count' => '10', 'score' => 33.30],
            ['attendance_count' => '11', 'score' => 36.63],
            ['attendance_count' => '12', 'score' => 40],
        ];

        foreach ($attendances as $attendance); {
            Attendance::create($attendance);
        }
    }
}
