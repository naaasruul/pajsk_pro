<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\CocuriculumActivity;
use App\Models\InvolvementType;
use App\Models\Student;
use App\Models\Teacher;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = CocuriculumActivity::with('student.user');

        if ($request->has('class')) {
            $query->where('class', $request->class);
        }

        if ($request->has('activity')) {
            $query->where('activity', $request->activity);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get unique values for filters
        $classes = CocuriculumActivity::distinct()->pluck('class');
        $activityTypes = CocuriculumActivity::distinct()->pluck('activity');

        return view('cocuriculum.activity', compact('activities', 'classes', 'activityTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the logged-in teacher
        $teacher = auth()->user()->teacher;

        // Get all involvement types
        $involvementTypes = InvolvementType::all();

        // Get all students
        $students = Student::with('user')->get();

        // Get all teachers
        $teachers = Teacher::with('user')->get();

        // Get all clubs
        $clubs = Club::all();

        return view('cocuriculum.create-activity', compact(
            'teacher', 
            'students', 
            'teachers',
            'involvementTypes',
            'clubs'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'no_maktab' => 'required|string',
            'class' => 'required|string',
            'activity' => 'required|string',
            'marks' => 'required|integer|min:0|max:100',
        ]);

        CocuriculumActivity::create($validated);

        return redirect()->route('activity.index')
            ->with('success', 'Activity created successfully.');
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CocuriculumActivity $cocuriculum)
    {
        return view('cocuriculum.edit', compact('cocuriculum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CocuriculumActivity $cocuriculum)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'no_maktab' => 'required|string',
            'class' => 'required|string',
            'activity' => 'required|string',
            'marks' => 'required|integer|min:0|max:100',
        ]);

        $cocuriculum->update($validated);

        return redirect()->route('cocuriculum.index')
            ->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
