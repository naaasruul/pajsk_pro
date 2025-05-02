<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExtraCocuriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $teacher = auth()->user()->teacher; // Assuming the logged-in user is a teacher
        $students = Student::where('mentor_id', $teacher->id)->paginate(10);
        Log::info('Students:', ['students' => $students]);
        return view('cocuriculum.extra-cocuriculum',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cocuriculum.create-extra-cocuriculum');
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
