<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

    // Route::get('/verify-email/student/{id}', [StudentController::class, 'verifyEmail']);
    // Route::post('/verify-phone/student', [StudentController::class, 'verifyPhone']);

});

// Route::get('/verify-email/{id}', function ($id) {
//     $student = \App\Models\Student::findOrFail($id);
//     $student->email_verified_at = now();
//     $student->save();

//     return response()->json(['message' => 'Email verified successfully']);
// });


Route::prefix('guardians')->group(function () {
    Route::get('/', [GuardianController::class, 'index']);            // List all guardians
    Route::post('/', [GuardianController::class, 'store']);           // Create a new guardian
    Route::get('/{guardian}', [GuardianController::class, 'show']);   // Show single guardian
    Route::put('/{guardian}', [GuardianController::class, 'update']); // Update guardian
    Route::delete('/{guardian}', [GuardianController::class, 'destroy']); // Delete guardian
    Route::post('/login', [GuardianController::class, 'login']);      // Guardian login
});


