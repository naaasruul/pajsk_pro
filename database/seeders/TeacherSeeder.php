<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        // Create 50 teachers with users
        $teachers = collect();
        for ($i = 1; $i <= 50; $i++) {

            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('teacher');

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'home_number' => fake()->phoneNumber()
            ]);

            $teachers->push($teacher);
        }

        $this->command->info('Created 50 teachers for testing');
    }
}
