<?php

use App\Http\Controllers\Activity\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CocuriculumController;
use App\Http\Controllers\ExtraCocuriculumController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PAJSKController;
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
        Route::prefix('activity')->name('activity.')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/create', [ActivityController::class, 'create'])->name('create');
            Route::post('/', [ActivityController::class, 'store'])->name('store');
            Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
            Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
            Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
        });
    });

    // Routes accessible by teachers only
    Route::middleware('role:teacher')->group(function () {
        Route::prefix('club')->name('club.')->group(function () {
            Route::get('/', [ClubController::class, 'index'])->name('index');
            Route::get('/add-student', [ClubController::class, 'showAddStudentForm'])->name('add-student');
            Route::post('/add-student', [ClubController::class, 'addStudent'])->name('store-student');
            Route::delete('/remove-student/{student}', [ClubController::class, 'removeStudent'])->name('remove-student');
        });
    });

    // Routes accessible by teachers only
    Route::middleware('role:teacher')->group(function () {
        Route::prefix('pajsk')->name('pajsk.')->group(function () {
            Route::get('/', [PAJSKController::class, 'index'])->name('index');
            Route::get('/evaluate-pajsk/{student}', [PAJSKController::class, 'evaluateStudent'])->name('evaluate-student');
            Route::get('/evaluate-student/{student}', [PAJSKController::class, 'evaluateStudent'])->name('evaluate-student');
            Route::post('/evaluate-student/{student}', [PAJSKController::class, 'storeEvaluation'])->name('store-evaluation');
        });
    });

    // Routes accessible by admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
});

require __DIR__.'/auth.php';
