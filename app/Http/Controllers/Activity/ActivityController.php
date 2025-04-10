<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CocuriculumActivity;

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
        
        return view('cocuriculum.cocuriculum', compact('activities', 'classes', 'activityTypes','club'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
