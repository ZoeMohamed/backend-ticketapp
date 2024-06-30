<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('pages.dashboard');
    });

    Route::resource('users', UserController::class);
});
// Route::get('/login', function () {
//     return view('pages.auth.login');
// });