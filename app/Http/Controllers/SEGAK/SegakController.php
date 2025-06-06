<?php

namespace App\Http\Controllers\SEGAK;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Segak;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        $teacher = $user->teacher;
        $pjkSubject = Subject::where('code', 'PJK')->first();

        if($user->hasRole('teacher')){
            $classIds = DB::table('classroom_subject_teacher')
            ->where('teacher_id', $teacher->id)
            ->where('subject_id', $pjkSubject->id)
            ->pluck('classroom_id')
            ->unique()
            ->toArray();
        }elseif($user->hasRole('admin')){
            $classIds = DB::table('classroom_subject_teacher')
            ->pluck('classroom_id');
        }

        $classes = Classroom::whereIn('id', $classIds)->get();

        return view('SEGAK.index', compact('classes'));
    }

    public function pickSession(Classroom $class_id){
        $user = auth()->user();
        $teacher = $user->teacher;
        $pjkSubject = Subject::where('code', 'PJK')->first();

        if($user->hasRole('teacher')){
            $classIds = DB::table('classroom_subject_teacher')
            ->where('teacher_id', $teacher->id)
            ->where('subject_id', $pjkSubject->id)
            ->pluck('classroom_id')
            ->unique()
            ->toArray();
        }elseif($user->hasRole('admin')){
            $classIds = DB::table('classroom_subject_teacher')
            ->pluck('classroom_id');
        }

        $classes = Classroom::whereIn('id', $classIds)->get();
        $class = Classroom::find($class_id->id);
        // Optionally, get students for the first class or let user select class first
        return view('SEGAK.pick-session', compact('class'));
    }

    public function pickStudent(Classroom $class_id, $session_id)
    {
        $user = auth()->user();
        $teacher = $user->teacher;
        $pjkSubject = Subject::where('code', 'PJK')->first();

        if($user->hasRole('teacher')){
            $classIds = DB::table('classroom_subject_teacher')
            ->where('teacher_id', $teacher->id)
            ->where('subject_id', $pjkSubject->id)
            ->pluck('classroom_id')
            ->unique()
            ->toArray();
        }elseif($user->hasRole('admin')){
            $classIds = DB::table('classroom_subject_teacher')
            ->pluck('classroom_id');
        }

        $classes = Classroom::whereIn('id', $classIds)->get();
        // $class = Classroom::find($class_id->id)->with('students');
        $class = Classroom::with('students')->find($class_id->id);


        // // // Get students for the selected class
        // dd($class->students());
        $students = $class->students()->get();

        // Pass session_id for context
        return view('SEGAK.pick-student', compact('class', 'session_id','students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $class_id, $session_id, Student $student_id)
    {
        $teacher = auth()->user()->teacher;
        $pjkSubject = Subject::where('code', 'PJK')->first();

        

        $classes = Classroom::whereIn('id', $classIds)->get();
        $class = Classroom::find($class_id->id);

        // Optionally, get students for the first class or let user select class first
        return view('SEGAK.create', compact('class', 'session_id','student_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'session' => 'required|in:1,2',
        'classroom_id' => 'required|exists:classrooms,id',
        'date' => 'required|date',
        'student_id' => 'required|exists:students,id',
        
        'weight' => 'required|numeric',
        'height' => 'required|numeric',
        'step_test_steps' => 'required|integer',
        'step_test_score' => 'required|integer',
        'push_up_steps' => 'required|integer',
        'push_up_score' => 'required|integer',
        'sit_up_steps' => 'required|integer',
        'sit_up_score' => 'required|integer',
        'sit_and_reach' => 'required|numeric',
        'sit_and_reach_score' => 'required|numeric',
        'total_score' => 'required|integer',
        'gred' => 'required|string|max:5',
        'bmi_status' => 'required|string|max:50',
    ]);

    // Save to database
    Segak::create($request->all());

    return redirect()->route('segak.index')->with('success', 'SEGAK record created!');
}

    /**
     * Display the specified resource.
     */
    public function showByClass(Classroom $class_id, $session_id)
    {
        //
        $students = $class_id->students;

        $segaks = Segak::with(['student', 'classroom'])
        ->where('classroom_id', $class_id->id)
        ->where('session', $session_id)
        ->get();

        return view('SEGAK.view-all-by-class', compact('class_id','session_id','students','segaks'));
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
