<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        $userAdmin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $userAdmin->assignRole('admin');

        $userTeacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
        ]);
        $userTeacher->assignRole('teacher');

        $userStudent = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $userStudent->assignRole('student');
        
        $userStudent = Student::create([
            'user_id' => $userStudent->id,
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'class' => rand(1,6) . ' ' . fake()->word(),
        ]);

        $this->call([
            AchievementSeeder::class,
            ClubPositionSeeder::class,
            ClubSeeder::class,
            CocurriculumSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            ScoringTablesSeeder::class,
            ClubStudentSeeder::class,
        ]);

        $userTeacher = Teacher::create([
            'user_id' => $userTeacher->id,
            'club_id' => 1,
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
        ]);
    }
}
