<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CocuriculumController;
use App\Http\Controllers\ExtraCocuriculumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    ///////////////////// ! development mode, allow admin to access this route, remove 'admin' once prod
    Route::middleware('role:teacher|admin')->group(function () {
        Route::prefix('cocuriculum')->name('cocuriculum.')->group(function () {
            Route::get('/', [CocuriculumController::class, 'index'])->name('index');
            Route::get('/create', [CocuriculumController::class, 'create'])->name('create');
            Route::post('/', [CocuriculumController::class, 'store'])->name('store');
            Route::get('/{cocuriculum}/edit', [CocuriculumController::class, 'edit'])->name('edit');
            Route::put('/{cocuriculum}', [CocuriculumController::class, 'update'])->name('update');
            Route::delete('/{cocuriculum}', [CocuriculumController::class, 'destroy'])->name('destroy');
            Route::get('/extra-cocuriculum', [ExtraCocuriculumController::class, 'index'])->name('extra-cocuriculum');
        });
    });

    // Routes accessible by admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
});

require __DIR__.'/auth.php';
