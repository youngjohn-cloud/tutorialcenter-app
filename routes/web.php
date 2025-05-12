<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->away('https://tutorialcenter.vercel.app/');
});

// Route::get('/', function () {
//     return view('welcome');
// });
