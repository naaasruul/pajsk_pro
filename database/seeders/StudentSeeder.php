<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Create 50 students with users
        $students = collect();
        for ($i = 1; $i <= 50; $i++) {

            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('student');

            $student = Student::create([
                'user_id' => $user->id,
                'phone_number' => fake()->phoneNumber(),
                'home_number' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'class' => rand(1,6) . ' ' . fake()->word(),
            ]);

            $students->push($student);
        }

        $this->command->info('Created 50 students for testing');
    }
}
