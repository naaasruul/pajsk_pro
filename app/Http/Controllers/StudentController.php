<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'classroom');
        
        if ($request->filled('year')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }

        if ($request->filled('class_name')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('class_name', 'LIKE', '%' . $request->class_name . '%');
            });
        }

        $students = $query->paginate(10)->appends($request->query());
        $years = Classroom::select('year')->distinct()->pluck('year');

        return view('student.index', compact('students', 'years'));
    }

    public function create()
    {
        $classroomsGrouped = Classroom::all()->groupBy('year');

        $teachers = User::role('teacher')->get();
        return view('student.create', compact('classroomsGrouped','teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'class_id'      => 'required|exists:classrooms,id',
            'gender'        => 'required',
            'teacher_id'    => 'exists:teachers,id',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'gender'   => $validated['gender'],
                'password' => Hash::make($validated['password']),
            ]);
            
            $user->assignRole('student');
            
    b            $user->student()->create([
                'mentor_id' => $validated['teacher_id'] ?? null,
                'address'       => $validated['address'],
                'phone_number'  => $validated['phone_number'],
                'home_number'   => $request->home_number ?? null,
                'class_id'  => $validated['class_id'],
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $classroomsGrouped = Classroom::all()->groupBy('year');
        return view('student.edit', compact('student', 'classroomsGrouped'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,'.$student->user->id,
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'home_number'   => 'required|string|max:20',
            'class_id'      => 'required|exists:classrooms,id',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'address'      => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'home_number'  => $validated['home_number'],
                'class_id'     => $validated['class_id'],
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->user->delete(); // This will cascade delete the student record
        });

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}