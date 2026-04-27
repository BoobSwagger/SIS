<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckStudent;

// --- Default Route ---
Route::get('/', function () {
    return redirect('/login');
});

// --- Authentication Routes (Public) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- SECURED ROUTES ---
// The 'auth' middleware ensures ONLY logged-in users can enter here
Route::middleware(['auth'])->group(function () {

    // 1. ADMIN ONLY ROUTES (Protected by our new CheckAdmin class)
    Route::middleware([CheckAdmin::class])->group(function () {
        Route::get('/students', [StudentController::class, 'index']);
        Route::get('/students/create', [StudentController::class, 'create']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::get('/students/{id}/edit', [StudentController::class, 'edit']);
        Route::put('/students/{id}', [StudentController::class, 'update']);
        Route::delete('/students/{id}', [StudentController::class, 'destroy']);
        Route::delete('/students/truncate', [StudentController::class, 'truncate']);
    });

    // 2. STUDENT ONLY ROUTES (Protected by our new CheckStudent class)
    Route::middleware([CheckStudent::class])->group(function () {
        
        // The Student Portal Route
        Route::get('/student/portal', function () {
            // Automatically fetch the exact data for the logged-in student
            $student = \App\Models\Student::where('student_id', auth()->user()->username)->first();
            return view('portal', compact('student'));
        });

    });

});