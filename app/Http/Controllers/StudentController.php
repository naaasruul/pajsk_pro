<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->paginate(10);
        return view('student.index', compact('students'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'class' => 'required|string|max:50',
            'gender' => 'required',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('student');

            $user->student()->create([
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'home_number' => $validated['home_number'] ?? null,
                'class' => $validated['class'],
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$student->user->id,
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'home_number' => 'required|string|max:20',
            'class' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'home_number' => $validated['home_number'],
                'class' => $validated['class'],
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