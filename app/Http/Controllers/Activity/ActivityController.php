<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\CocuriculumActivity;
use App\Models\InvolvementType;
use App\Models\Placement;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use DB;

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
        $teacher = auth()->user()->teacher;
        
        return view('cocuriculum.create-activity', [
            'teacher' => $teacher,
            'students' => Student::with('user')->get(),
            'teachers' => Teacher::with('user')->get(),
            'involvementTypes' => InvolvementType::orderBy('type')->get(),
            'clubs' => Club::all(),
            'achievementTypes' => Achievement::all(), // Add this line
            'placements' => Placement::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'represent' => 'required',
            'placement_id' => 'exists:placements,id',
            'involvement_id' => 'required|exists:involvement_types,id',
            'achievement_id' => 'required|exists:achievements,id',
            'club_id' => 'required|exists:clubs,id', // Ensure the club exists
            'activity_place' => 'required|string|max:255',
            'datetime_start' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'datetime_end' => 'required|date|after_or_equal:datetime_start',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        // Retrieve the club to get its category
        $club = Club::findOrFail($validated['club_id']);

        // Get the score from pivot table based on involvement type and achievement
        $involvementType = InvolvementType::find($validated['involvement_id']);
        $score = DB::table('achievement_involvement')
            ->where([
                'involvement_type_id' => $involvementType->type, // Use the type column
                'achievement_id' => $validated['achievement_id']
            ])
            ->value('score');

        Log::info('Activity Score', [
            'involvement_type' => $involvementType->type,
            'achievement_id' => $validated['achievement_id'],
            'score' => $score
        ]);
        Log::info('Activity Data', $validated);

        // Create the activity
        $activity = Activity::create([
            'represent' => $validated['represent'],
            // 'placement_id' => $validated['placement_id'], // Add this line
            'involvement_id' => $validated['involvement_id'],
            'achievement_id' => $validated['achievement_id'],
            'club_id' => $validated['club_id'],
            'category' => $club->category, // Assign the category from the club
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

    public function adminApproval(Request $request)
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(10);
    
        return view('cocuriculum.approval', compact('activities'));
    }

    public function applications_approved($id)
    {
        $activity = Activity::findOrFail($id); // Find the activity by ID
        $activity->update(['status' => 'approved']); // Update the status to 'approved'
        Log::info('Activity approved: ' . $activity->id);

        return redirect()->back()
            ->with('success', 'Activity approved successfully.');
    }

    public function applications_rejected($id)
    {
        $activity = Activity::findOrFail($id); // Find the activity by ID
        $activity->update(['status' => 'rejected']); // Update the status to 'rejected'
        Log::info('Activity rejected: ' . $activity->id);

        return redirect()->back()
            ->with('success', 'Activity rejected successfully.');
    }


}
