<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CocuriculumActivity;
use Illuminate\Http\Request;

class CocuriculumController extends Controller
{
    public function index(Request $request)
    {
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

        return view('cocuriculum.cocuriculum', compact('activities', 'classes', 'activityTypes'));
    }

    public function create()
    {
        return view('cocuriculum.create');
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
