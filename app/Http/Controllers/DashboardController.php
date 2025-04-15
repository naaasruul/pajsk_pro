<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $activitiesCount = Activity::count(); // Total activities
            $teachersCount = Teacher::count(); // Total teachers
            $studentsCount = Student::count(); // Total students

            return view('dashboard.admin', compact('activitiesCount', 'teachersCount', 'studentsCount'));
        } elseif ($user->hasRole('teacher')) {
            $teacher = $user->teacher; // Get the teacher associated with the user
            $activities = $teacher->activities()->count(); // Activities assigned to the teacher

            $club = $teacher ? $teacher->club : null;
            
            // Get all students
            $allStudentsCount = Student::with('user')->count(); // Total students
            
            // Get students in the teacher's clubs
            $clubStudentsCount = $club ? $club->students()->with('user')->count() : null;
            
            // Calculate non-club students
            $nonClubStudentsCount = $allStudentsCount - $clubStudentsCount;

            // Calculate percentages
            $allStudentsPercentage = $allStudentsCount > 0 ? 100 : 0;
            $clubStudentsPercentage = $allStudentsCount > 0 ? ($clubStudentsCount / $allStudentsCount) * 100 : 0;
            $nonClubStudentsPercentage = $allStudentsCount > 0 ? ($nonClubStudentsCount / $allStudentsCount) * 100 : 0;

            return view('dashboard.teacher', compact(
                'teacher', 
                'activities',
                'clubStudentsCount',
                'allStudentsCount',
                'nonClubStudentsCount',
                'allStudentsPercentage',
                'clubStudentsPercentage',
                'nonClubStudentsPercentage',
            ));
        } elseif ($user->hasRole('student')) {
            $student = $user->student; // Get the student associated with the user
            $activities = $student->activities()->count(); // Activities assigned to the student

            return view('dashboard.student', compact('student', 'activities'));
        }

        // Return back with an error message
        return back()->withErrors(['error' => 'You do not have access to the dashboard.']);
    }
}
