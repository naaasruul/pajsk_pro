<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        } elseif ($user->hasRole('teacher')) {
            return view('dashboard.teacher');
        } elseif ($user->hasRole('student')) {
            return view('dashboard.student');
        }

        // Return back with an error message
        return back()->withErrors(['error' => 'You do not have access to the dashboard.']);
    }
}