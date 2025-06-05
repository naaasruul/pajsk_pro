<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    //
    public function index()
    {
        $subjects = Subject::with('teachers')->get();
        $teachers = Teacher::all();
        $classes = Classroom::all();

        return view('subjects.index',compact('subjects','teachers','classes'));
    }

    public function create()
    {
        $subjects = Subject::with('teachers')->get();
        return view('subjects.create',compact('subjects'));
    }
    
    public function edit()
    {
        $subjects = Subject::with('teachers')->get();
        return view('subjects.edit',compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        Subject::create($request->all());

        return redirect()->route('subject.index')->with('success', 'Subject created successfully.');
    }

    public function assignTeachers(Request $request, Subject $subject)
    {
        $subject->teachers()->sync($request->teacher_ids); // assign selected teachers
        return back()->with('success', 'Teachers assigned successfully!');
    }

    public function assignTeacherToClass(Request $request, Subject $subject)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        // Save to the pivot table classroom_subject_teacher
        DB::table('classroom_subject_teacher')->updateOrInsert(
            [
                'subject_id' => $subject->id,
                'teacher_id' => $request->teacher_id,
                'classroom_id' => $request->classroom_id,
            ],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return back()->with('success', 'Teacher assigned to subject and class successfully!');
    }


}
