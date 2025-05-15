<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Retrieve all classrooms from the database
        $classrooms = Classroom::all();
        $yearsix = Classroom::where('year', 6)->get();

        // Create 50 students with users
        $students = collect();
        for ($i = 1; $i <= 50; $i++) {

            $user = User::create([
                'name' => fake()->unique()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('student');

            $student = Student::create([
                'user_id' => $user->id,
                'phone_number' => fake()->phoneNumber(),
                'home_number' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'class_id' => $classrooms->random()->id,
                // 'class_id' => $yearsix->random()->id,
            ]);

            $students->push($student);
            // $this->command->info($students);
        }

        $this->command->info('Created 50 students for testing');
    }
}
