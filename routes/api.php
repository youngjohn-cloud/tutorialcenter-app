<?php
// composer require laravel/sanctum
// php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"


use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectEnrollmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ModuleController;

// Student API Routes
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']); // List all students
    Route::post('/register', [StudentController::class, 'store']); // Create a new student
    Route::post('/verify', [StudentController::class, 'verify']); // Email Verification
    Route::get('{student}', [StudentController::class, 'show']); // Show specific student
    Route::put('{student}', [StudentController::class, 'update']); // Update a student
    Route::delete('{student}', [StudentController::class, 'destroy']); // Delete a student
    Route::patch('/resend-code', [StudentController::class, 'resendCode']); //resend verification code
    Route::get('/{id}/courses-subjects', [StudentController::class, 'getStudentCoursesAndSubjects']); // gets student enrolled courses and subjects


    Route::post('login', [StudentController::class, 'login']); // Login student
    Route::post('/enroll', [StudentController::class, 'enroll']); //student enroll in a course


    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogleStudent']);  //student login or register using google auth
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
    Route::patch('/resend-code', [GuardianController::class, 'resendCode']); //resend verification code

    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogleGuardian']);  //gurdian login or register using google auth(redirect to google)
});

// student and guardian Shared google callback(callback url in google console need to be changed to api for this to work)
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Staff API Routes
Route::prefix('staffs')->group(function () {
    Route::get('/', [StaffController::class, 'index']); // List all staff
    Route::post('/verify', [StaffController::class, 'verify']); // Email Verification
    Route::post('/login', [StaffController::class, 'login']); // Staff login
    Route::get('/{staff}', [StaffController::class, 'show']); // Show specific staff

    // Forgot & Change Password (open/public)
    Route::post('/forgot-password', [StaffController::class, 'forgotPassword']);
    Route::post('/change-password', [StaffController::class, 'changePassword']);

    // Protected routes (only for authenticated staffs)
    Route::middleware(['auth:sanctum', 'type.staff'])->group(function () {
        Route::post('/logout', [StaffController::class, 'logout']); // Logout

        // Admin-only routes
        Route::middleware(['staff.role:admin'])->group(function () {
            Route::post('/register', [StaffController::class, 'store']); // Create staff
            Route::put('/{staff}', [StaffController::class, 'update']); // Update staff
            Route::delete('/{staff}', [StaffController::class, 'destroy']); // Delete staff
            Route::post('/createclass', [CourseController::class, 'store']); // Create course
        });
    });
});
// Route::prefix('staffs')->group(function () {
//     Route::get('/', [StaffController::class, 'index']); // List all staff
//     Route::post('/verify', [StaffController::class, 'verify']); // Email Verification
//     Route::post('/login', [StaffController::class, 'login']); //staff login
//     Route::get('/{staff}', [StaffController::class, 'show']); // Show specific staff

//     // Route::post('/register', [StaffController::class, 'store']); // Create a new staff

//     Route::middleware(['auth:sanctum', 'type.staff', 'staff.role:admin'])->group(function () {
//         Route::post('/register', [StaffController::class, 'store']); // Create a new staff
//         Route::put('/{staff}', [StaffController::class, 'update']); // Update a staff
//         Route::delete('/{staff}', [StaffController::class, 'destroy']); // Delete a staff
//         Route::post('/createclass', [CourseController::class, 'store']); // Create course route 
//     });
// });

// Course (Classes) API Routes 
Route::prefix('courses')->group(function () {
Route::get('/', [CourseController::class, 'index']); // List all active course
Route::get('/{id}', [CourseController::class, 'show']); // Show course by ID or slug

/**
 * Route only accessible by admin for subjects
 */
Route::middleware(['auth:sanctum', 'type.staff', 'staff.role:admin'])->group(function () {
    Route::post('/', [CourseController::class, 'store']); // Create courses
    Route::put('/{id}', [CourseController::class, 'update']); // Update course
    Route::delete('/{id}', [CourseController::class, 'destroy']); // Delete course
});
});

// Subject API Routes
Route::prefix('subjects')->group(function () {
    Route::get('/', [SubjectController::class, 'index']); // List all published subjects

    Route::get('/{id}', [SubjectController::class, 'show']); // Show published subject by ID

    /**
     * Route only accessible by admin for subjects
     */
    Route::middleware(['auth:sanctum', 'type.staff', 'staff.role:admin'])->group(function () {
        Route::post('/', [SubjectController::class, 'store']); // Create subject
        Route::put('/{id}', [SubjectController::class, 'update']); // Update subject
        Route::delete('/{id}', [SubjectController::class, 'destroy']); // Delete subject
    });
});

// Module API Routes
Route::prefix('modules')->group(function () {
    Route::get('/', [ModuleController::class, 'index']); // List all modules
    Route::get('/{id}', [ModuleController::class, 'show']); // Show module by ID

    // Admin-only module management
    Route::middleware(['auth:sanctum', 'type.staff', 'staff.role:admin'])->group(function () {
        Route::post('/', [ModuleController::class, 'store']); // Create module
        Route::put('/{id}', [ModuleController::class, 'update']); // Update module
        Route::delete('/{id}', [ModuleController::class, 'destroy']); // Delete module
    });

    // // Optional helper routes
    // Route::get('/course/{courseId}', [ModuleController::class, 'forCourse']); // Modules for a course
    // Route::get('/subject/{subjectId}', [ModuleController::class, 'forSubject']); // Modules for a subject
});

// Lesson API Routes
Route::prefix('lessons')->group(function () {
    Route::get('/', [LessonController::class, 'index']); // List all modules
    Route::get('/{id}', [LessonController::class, 'show']); // Show module by ID

    // Admin-only module management
    Route::middleware(['auth:sanctum', 'type.staff', 'staff.role:admin'])->group(function () {
        Route::post('/', [LessonController::class, 'store']); // Create module
        Route::put('/{id}', [LessonController::class, 'update']); // Update module
        Route::delete('/{id}', [LessonController::class, 'destroy']); // Delete module
    });
});

//payment route
Route::post('/payments', [PaymentController::class, 'store']);

Route::patch('/subject-enrollments/{id}', [SubjectEnrollmentController::class, 'update']);
Route::post('/enrollments', [EnrollmentController::class, 'store']);