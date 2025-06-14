<?php

use App\Http\Controllers\Activity\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CocuriculumController;
use App\Http\Controllers\ExtraCocuriculumController;
use App\Http\Controllers\PAJSKController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\SEGAK\SegakController;
use App\Http\Controllers\Subject\SubjectController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/evaluations', [PAJSKController::class, 'history'])->name('pajsk.history');
    Route::get('/result/student/{student}/evaluation/{evaluation}', [PAJSKController::class, 'result'])->name('pajsk.result');
    Route::get('/report/student/{student}/report/{report}', [PAJSKController::class, 'showReport'])->name('pajsk.show-report');
    Route::get('pajsk/report-history', [PAJSKController::class, 'reportHistory'])->name('pajsk.report-history');

    // Routes accessible by admin and teachers
    Route::middleware('role:admin|teacher')->group(function () {    
        Route::resource('students', StudentController::class);
        Route::resource('classrooms', ClassroomController::class);
        // Added disable route for classrooms
        Route::get('classrooms/{classroom}/disable', [ClassroomController::class, 'disable'])->name('classrooms.disable');

        // PAJSK routes
        Route::prefix('pajsk')->name('pajsk.')->group(function () {

            Route::get('/extra-cocuriculum', [ExtraCocuriculumController::class, 'index'])->name('extra-cocuriculum');
            Route::get('/extra-cocuriculum/history', [ExtraCocuriculumController::class, 'history'])->name('extra-cocuriculum.history');
            Route::get('/extra-cocuriculum/result/student/{student}/evaluation/{evaluation}', [ExtraCocuriculumController::class, 'result'])->name('extra-cocuriculum.result');
            
            Route::get('pajsk/report/{student}/{assessment}', [PAJSKController::class, 'generateReport'])->name('generate-report');
            Route::delete('pajsk/report/{report}', [PAJSKController::class, 'destroyReport'])->name('delete-report');
        });

        // SEGAK ROUTES
    
    });
    // segak can access by admin and teacher and student
    Route::middleware('role:admin|teacher|student')->group(function () { 
        Route::prefix('segak')->name('segak.')->group(function () {
            Route::get('/', [SegakController::class, 'index'])->name('index');
            Route::get('/pick-session/class/{class_id}', [SegakController::class, 'pickSession'])->name('pick-session');
            Route::get('/pick-session/class/{class_id}/session/{session_id}', [SegakController::class, 'pickStudent'])->name('pick-student');
            Route::get('/pick-session/class/{class_id}/session/{session_id}/student/{student_id}/create', [SegakController::class, 'create'])->name('create');
            Route::post('/store', [SegakController::class, 'store'])->name('store');

            Route::get('/pick-session/class/{class_id}/session/{session_id}/view-class', [SegakController::class, 'showByClass'])->name('view-class');
            Route::get('/pick-session/session/{session_id}/view-student/{student_id}', [SegakController::class, 'showByStudent'])->name('view-student');
        });
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

        Route::prefix('subjects')->name('subject.')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])->name('index');
            Route::get('/create', [SubjectController::class, 'create'])->name('create');
            Route::get('/edit', [SubjectController::class, 'edit'])->name('edit');

            Route::post('/store', [SubjectController::class, 'store'])->name('store');
            Route::post('/{subject}/assign-teachers', [SubjectController::class, 'assignTeachers'])->name('assignTeachers');
            Route::post('/{subject}/assign-teacher-to-class', [SubjectController::class, 'assignTeacherToClass'])->name('assignTeacherToClass');
        });


        Route::prefix('activity')->name('activity.')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/create', [ActivityController::class, 'create'])->name('create');
            Route::post('/', [ActivityController::class, 'store'])->name('store');
            Route::get('/{activity}/edit', [ActivityController::class, 'editActivity'])->name('edit');
            Route::put('/{activity}', [ActivityController::class, 'updateActivity'])->name('update');
            Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
        });
    });

    // Routes accessible by teachers only
    Route::middleware('role:teacher')->group(function () {
        Route::prefix('club')->name('club.')->group(function () {
            Route::get('/', [ClubController::class, 'index'])->name('index');
            Route::get('/add-student', [ClubController::class, 'showAddStudentForm'])->name('add-student');
            Route::post('/add-student', [ClubController::class, 'addStudent'])->name('store-student');
            Route::get('/{student}/edit', [ClubController::class, 'editStudent'])->name('edit-student');
            Route::put('/{student}/update', [ClubController::class, 'updateStudent'])->name('update-student');
            Route::delete('/remove-student/{student}', [ClubController::class, 'removeStudent'])->name('remove-student');
        });

    });


    // Routes accessible by admin only
    Route::middleware('role:admin')->group(function () {
        Route::prefix('activity')->name('activity.')->group(function(){
            Route::get('/applications', [ActivityController::class, 'adminApproval'])->name('approval');
            Route::post('/applications/{id}/approve', [ActivityController::class, 'applications_approved'])->name('approve');
            Route::post('/applications/{id}/reject', [ActivityController::class, 'applications_rejected'])->name('reject');
        });
        Route::resource('teachers', TeacherController::class);
    });

    // Routes accessible by teachers only
    Route::middleware('role:teacher')->group(function () {
        Route::prefix('pajsk')->name('pajsk.')->group(function () {
            Route::get('/', [PAJSKController::class, 'index'])->name('index');
            Route::get('/evaluate-pajsk/{student}', [PAJSKController::class, 'evaluateStudent'])->name('evaluate-student');
            Route::get('/evaluate-student/{student}', [PAJSKController::class, 'evaluateStudent'])->name('evaluate-student');
            Route::post('/evaluate-student/{student}', [PAJSKController::class, 'storeEvaluation'])->name('store-evaluation');

            // Extra cocuriculum routes
            Route::get('/extra-cocuriculum/{student}/create', [ExtraCocuriculumController::class, 'create'])->name('extra-cocuriculum.create');
            Route::post('/extra-cocuriculum/{student}/store', [ExtraCocuriculumController::class, 'store'])->name('extra-cocuriculum.store');
        });
    });
});

require __DIR__.'/auth.php';
