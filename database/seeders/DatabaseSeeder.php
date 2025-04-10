<?php

namespace Database\Seeders;

use App\Models\Attendance;
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

        $this->call([
            AchievementSeeder::class,
            AttendanceSeeder::class,
            ClubPositionSeeder::class,
            ClubSeeder::class,
            CocurriculumSeeder::class,
            CommitmentSeeder::class,
            ServiceContributionSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
        ]);
    }
}
