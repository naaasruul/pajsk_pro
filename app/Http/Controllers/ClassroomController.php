<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::with('user')->paginate(10);
        return view('classroom.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view to create a new classroom
        return view('classroom.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'year' => 'required|integer',
            'class_name' => 'required|string|max:255',
            'active_status' => 'boolean',
        ]);

        // Create a new classroom
        Classroom::create($request->all());

        // Redirect to the classrooms index with a success message
        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classrooms = Classroom::with('user')->paginate(10);
        return view('classroom.index', compact('classrooms'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the classroom by ID
        $classroom = Classroom::findOrFail($id);
        $teachers = Teacher::all();
        // Return the view to edit the classroom
        return view('classroom.edit', compact('classroom','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'year' => 'required|integer',
            'class_name' => 'required|string|max:255',
        ]);

        // Find the classroom by ID and update it
        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());

        // Redirect to the classrooms index with a success message
        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    /**
     * Disable the specified classroom.
     */
    public function disable(string $id)
    {
        // Find the classroom by ID
        $classroom = Classroom::findOrFail($id);

        if($classroom->active_status === 0) {
            // Disable the classroom by setting status column to 0
            $classroom->update(['active_status' => 1]);
            return redirect()->route('classrooms.index')->with('success', 'Classroom enabled successfully.');
        } else {
            // Enable the classroom by setting status column to 1
            $classroom->update(['active_status' => 0]);
            return redirect()->route('classrooms.index')->with('success', 'Classroom disabled successfully.');
        }

        // Redirect to the classrooms index with a error message
        return redirect()->route('classrooms.index')->with('error', 'An error occurred while updating the classroom.');
    }
}
