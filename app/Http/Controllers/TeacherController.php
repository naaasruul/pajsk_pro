<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('teacher.index', compact('teachers'));
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'home_number' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('teacher');

            $user->teacher()->create([
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'home_number' => $validated['home_number'],
            ]);
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$teacher->user->id,
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'home_number' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($validated, $teacher) {
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $teacher->update([
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'home_number' => $validated['home_number'],
            ]);
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            $teacher->user->delete(); // This will cascade delete the teacher record
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}