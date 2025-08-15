<?php
// composer require laravel/sanctum
// php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"


use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
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

// Guardian API Routes
Route::prefix('guardians')->group(function () {
    Route::get('/', [GuardianController::class, 'index']);            // List all guardians
    Route::post('/register', [GuardianController::class, 'store']);           // Create a new guardian
    Route::post('/verify', [GuardianController::class, 'verify']); // Email Verification
    Route::get('/{guardian}', [GuardianController::class, 'show']);   // Show single guardian
    Route::put('/{guardian}', [GuardianController::class, 'update']); // Update guardian
    Route::delete('/{guardian}', [GuardianController::class, 'destroy']); // Delete guardian
    Route::post('/login', [GuardianController::class, 'login']);      // Guardian login
});

// Staff API Routes
Route::prefix('staffs')->group(function () {
    Route::get('/', [StaffController::class, 'index']); // List all staff
    Route::post('/register', [StaffController::class, 'store']); // Create a new staff
    Route::post('/verify', [StaffController::class, 'verify']); // Email Verification
    Route::get('/{staff}', [StaffController::class, 'show']); // Show specific staff
    Route::put('/{staff}', [StaffController::class, 'update']); // Update a staff
    Route::delete('/{staff}', [StaffController::class, 'destroy']); // Delete a staff
    Route::post('/login', [StaffController::class, 'login']); //staff login
    
    Route::middleware('auth:sanctum')->group(function (){
        // Route::post('/register', [StaffController::class, 'store']); // Create a new staff

    });
    // Section Routes
    Route::post('/createclass', [SectionController::class, 'store']);
});


// Section (Classes) API Routes 
Route::prefix('sections')->group(function () {
    Route::get('/', [SectionController::class, 'index']);         // List all active sections
    Route::post('/', [SectionController::class, 'store']);        // Create section
    Route::get('/{id}', [SectionController::class, 'show']);      // Show section by ID or slug
    Route::put('/{id}', [SectionController::class, 'update']);    // Update section
    Route::delete('/{id}', [SectionController::class, 'destroy']); // Delete section
});

// Subjects API Routes
Route::prefix('subjects')->group(function () {
    Route::get('/', [SubjectController::class, 'index']);         // List all active subjects
    Route::post('/', [SubjectController::class, 'store']);        // Create subject
    Route::get('/{id}', [SubjectController::class, 'show']);      // Show subject by ID
    Route::put('/{id}', [SubjectController::class, 'update']);    // Update subject
    Route::delete('/{id}', [SubjectController::class, 'destroy']); // Delete subject
});


