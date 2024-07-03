<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // check auth for base url
    if (Auth::check()) {

        return redirect(route('home'));
    } else {

        return redirect(route('login'));
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
});
// Route::get('/login', function () {
//     return view('pages.auth.login');
// });