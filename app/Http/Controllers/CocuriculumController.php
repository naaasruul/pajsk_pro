<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClubPosition;
use App\Models\CocuriculumActivity;
use App\Models\Student;
use Illuminate\Http\Request;

class CocuriculumController extends Controller
{
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher; // Assuming the logged-in user is a teacher
        $club = $teacher ? $teacher->club : null;

        // Preload all students with their positions in the specific club
        $studentsWithPositions = $club ? $club->students->map(function ($student) use ($club) {
            $position = $student->pivot->club_position_id
                ? ClubPosition::where('id', $student->pivot->club_position_id)
                    ->where('club_id', $club->id) // Ensure the position is for the specific club
                    ->first()
                : null;

            return [
                'id' => $student->id,
                'name' => $student->user->name,
                'position_name' => $position ? $position->position_name : 'No Position',
            ];
        }) : [];

        return view('cocuriculum.cocuriculum', compact('studentsWithPositions', 'club', 'teacher'));
    }

    public function create()
    {
        // get all students
        $students = Student::with('user')->get();
        return view('cocuriculum.create', compact('students'));
    }

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

        return redirect()->route('cocuriculum.index')
            ->with('success', 'Activity created successfully.');
    }

    public function edit(CocuriculumActivity $cocuriculum)
    {
        return view('cocuriculum.edit', compact('cocuriculum'));
    }

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

    public function destroy(CocuriculumActivity $cocuriculum)
    {
        $cocuriculum->delete();

        return redirect()->route('cocuriculum.index')
            ->with('success', 'Activity deleted successfully.');
    }
}
