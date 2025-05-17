<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ExtraCocuricullum;
use App\Models\PajskAssessment;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Student;
use App\Models\Club;
use App\Models\Activity;
use App\Models\PajskReport;

class OldDataAntiSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command->confirm(
            "Are you sure you want to run this seeder?\n".
            "The following tables will have their data deleted:\n".
            "- users (except critical users)\n".
            "- classrooms (years 1 to 6)\n".
            "- extra_cocuricullums (linked to classrooms)\n".
            "- pajsk_assessments (linked to classrooms)\n".
            "- pajsk_reports (linked to classrooms)\n".
            "- students (all)\n".
            // "- clubs (all)\n".
            "- club_student (pivot)\n".
            "- activities (all)\n".
            "This operation cannot be undone. Proceed?", false)) 
        {
            // Revert user records seeded by StudentSeeder (except for critical users)
            User::whereNotIn('id', [1, 2, 3, 4, 5])->delete();

            // Get IDs of classrooms for years 1 to 6 seeded by ClassroomSeeder
            $classroomIds = Classroom::whereBetween('year', [1, 6])->pluck('id')->toArray();

            // Delete ExtraCocuricullum records created by OldDataSeeder
            ExtraCocuricullum::whereIn('class_id', $classroomIds)->delete();

            // Delete PajskAssessment records created by OldDataSeeder
            PajskAssessment::whereIn('class_id', $classroomIds)->delete();
            PajskReport::whereIn('class_id', $classroomIds)->delete();

            // --- Revert data seeded by additional seeders called in OldDataSeeder ---
            // Delete classroom records seeded by ClassroomSeeder
            Classroom::whereBetween('year', [1, 6])->delete(); // Reverts ClassroomSeeder

            // Delete student records seeded by StudentSeeder
            Student::query()->delete(); // Reverts StudentSeeder without foreign key constraint issues

            // // Delete club records seeded by ClubSeeder
            // Club::query()->delete(); // Reverts ClubSeeder

            // Clear pivot records seeded by ClubStudentSeeder
            DB::table('club_student')->delete(); // Reverts ClubStudentSeeder

            // Delete activity records seeded by ActivitySeeder
            Activity::query()->delete(); // Reverts ActivitySeeder

            $this->command->info('Old data from OldDataSeeder and its dependent seeders deleted successfully!');
        } else {
            $this->command->info('Old data seeder rollback aborted.');
        }
    }
}
