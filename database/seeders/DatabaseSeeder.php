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

        $userTeacherKelab = User::create([
            'name' => 'Manab (Kelab)',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
        ]);
        $userTeacherKelab->assignRole('teacher');

        $userTeacherUniform = User::create([
            'name' => 'Maznah (Uniform)',
            'email' => 'teacherU@example.com',
            'password' => bcrypt('password'),
        ]);
        $userTeacherUniform->assignRole('teacher');

        $userTeacherSukan = User::create([
            'name' => 'Bedah (Sukan)',
            'email' => 'teacherS@example.com',
            'password' => bcrypt('password'),
        ]);
        $userTeacherSukan->assignRole('teacher');

        // $userStudent = User::create([
        //     'name' => 'Student User',
        //     'email' => 'student@example.com',
        //     'password' => bcrypt('password'),
        // ]);
        // $userStudent->assignRole('student');

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
            // ExtraCocuSeeder::class,
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

        // $userStudent = Student::create([
        //     'user_id' => $userStudent->id,
        //     'phone_number' => fake()->phoneNumber(),
        //     'home_number' => fake()->phoneNumber(),
        //     'address' => fake()->address(),
        //     'class_id' => $class->id,
        // ]);

        $userTeacherKelab = Teacher::create([
            'user_id' => $userTeacherKelab->id,
            'club_id' => 1, // Kelab Muzik
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
        ]);

        $userTeacherUniform = Teacher::create([
            'user_id' => $userTeacherUniform->id,
            'club_id' => 3, // Kadet Polis
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
        ]);

        $userTeacherSukan = Teacher::create([
            'user_id' => $userTeacherSukan->id,
            'club_id' => 2, // Kelab Sukan
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'home_number' => fake()->phoneNumber(),
        ]);
    }
}
