<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Classroom;
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

        $this->call([
            InvolvementTypeSeeder::class,    // Add this first
            AchievementSeeder::class,        // Then this
            AchievementInvolvementSeeder::class, // Then this
            AttendanceSeeder::class,
            ClubPositionSeeder::class,
            ClubSeeder::class,
            ClubStudentSeeder::class,
            CocurriculumSeeder::class,
            CommitmentSeeder::class,
            ServiceContributionSeeder::class,
            PlacementSeeder::class,
            AchievementPlacementSeeder::class,
            ExtraCocuServices::class,
            ExtraCocuSpecialAwards::class,
            ExtraCocuCommunityServices::class,
            ExtraCocuTIMMS_PISA::class,
            NilamSeeder::class,
            ExtraCocuSeeder::class,
            // ClassroomSeeder::class,
            // ActivitySeeder::class,
            // StudentSeeder::class,
            // TeacherSeeder::class,
        ]);

        $class = Classroom::create([
            'year' => 1,
            'class_name' => 'Ikhlas',
            'active_status' => 1,
        ]);

        Classroom::create([
            'year' => 2,
            'class_name' => 'Zuhud',
            'active_status' => 1,
        ]);

        $userStudent = Student::create([
            'user_id' => $userStudent->id,
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'class_id' => $class->id,
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
