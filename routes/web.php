<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Cocuriculum;
use App\Http\Controllers\ExtraCocuriculum;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessible by admin and teachers
    Route::middleware('role:admin|teacher')->group(function () {
        Route::resource('students', StudentController::class);
    });

    // Routes accessible by teachers only
    Route::middleware('role:teacher')->prefix('cocuriculum')->name('cocuriculum.')->group(function () {
        Route::get('/', [Cocuriculum::class, 'index'])->name('index');
        Route::get('/extra-cocuriculum', [ExtraCocuriculum::class, 'index'])->name('index.extra-cocuriculum');
    });

    // Routes accessible by admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
});

require __DIR__.'/auth.php';
