<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuardianController;

// Student API Routes
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']); // List all students
    Route::post('/register', [StudentController::class, 'store']); // Create a new student
    Route::post('/verify', [StudentController::class, 'verify']); // Email Verification
    Route::get('{student}', [StudentController::class, 'show']); // Show specific student
    Route::put('{student}', [StudentController::class, 'update']); // Update a student
    Route::delete('{student}', [StudentController::class, 'destroy']); // Delete a student


    Route::post('login', [StudentController::class, 'login']); // Login student
    Route::post('/enroll', [StudentController::class, 'enroll']); //student enroll in a course

});

Route::prefix('guardians')->group(function () {
    Route::get('/', [GuardianController::class, 'index']);            // List all guardians
    Route::post('/register', [GuardianController::class, 'store']);           // Create a new guardian
    Route::post('/verify', [GuardianController::class, 'verify']); // Email Verification
    Route::get('/{guardian}', [GuardianController::class, 'show']);   // Show single guardian
    Route::put('/{guardian}', [GuardianController::class, 'update']); // Update guardian
    Route::delete('/{guardian}', [GuardianController::class, 'destroy']); // Delete guardian
    Route::post('/login', [GuardianController::class, 'login']);      // Guardian login
});

Route::prefix('staffs')->group(function () {
    Route::get('/', [StaffController::class, 'index']); // List all staff
    Route::post('/register', [StaffController::class, 'store']); // Create a new staff
    Route::post('/verify', [StaffController::class, 'verify']); // Email Verification
    Route::get('/{staff}', [StaffController::class, 'show']); // Show specific staff
    Route::put('/{staff}', [StaffController::class, 'update']); // Update a staff
    Route::delete('/{staff}', [StaffController::class, 'destroy']); // Delete a staff
    Route::post('/login', [StaffController::class, 'login']); //staff login
});

