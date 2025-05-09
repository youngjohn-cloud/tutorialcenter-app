<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

Route::get('/verify-email/{id}', [StudentController::class, 'verifyEmail'])->name('student.verify.email');


Route::get('/', function () {
    return view('welcome');
});
