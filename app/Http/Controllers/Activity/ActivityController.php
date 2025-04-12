<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\CocuriculumActivity;
use App\Models\InvolvementType;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $teacher = auth()->user()->teacher; // Assuming the logged-in user is a teacher

        $query = Activity::where('created_by', $teacher->id);

        $activities = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('cocuriculum.activity', compact('activities'));
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

        // Get all achievement types
        $achievementTypes = Achievement::all();

        return view('cocuriculum.create-activity', compact(
            'teacher', 
            'students', 
            'teachers',
            'involvementTypes',
            'clubs',
            'achievementTypes'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'represent' => 'required',
            'achievement_id' => 'required|exists:achievements,id',
            'involvement_id' => 'required|exists:involvement_types,id',
            'club_id' => 'required|exists:clubs,id',
            'activity_place' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'datetime_start' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'datetime_end' => 'required|date|after_or_equal:datetime_start',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);
        Log::info($validated);
        // Create the activity
        $activity = Activity::create([
            'represent' => $validated['represent'],
            'involvement_id' => $validated['involvement_id'],
            'achievement_id' => $validated['achievement_id'],
            'club_id' => $validated['club_id'],
            'category' => $validated['category'],
            'activity_place' => $validated['activity_place'],
            'date_start' => $validated['datetime_start'],
            'time_start' => $validated['time_start'],
            'date_end' => $validated['datetime_end'],
            'time_end' => $validated['time_end'],
            'created_by' => auth()->user()->teacher->id // Assuming the logged-in user is a teacher
        ]);
    
        // Attach teachers to the activity (if any)
        if (!empty($validated['teachers'])) {
            $activity->teachers()->sync($validated['teachers']);
        }
    
        // Attach students to the activity (if any)
        if (!empty($validated['students'])) {
            $activity->students()->sync($validated['students']);
        }
    
        // Return a success response
        return response()->json([
            'message' => 'Activity created successfully!',
            'activity' => $activity,
        ], 201);
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

    public function adminApproval()
    {
        $activities = Activity::all();
        return view('cocuriculum.approval', compact('activities'));
    }
}
