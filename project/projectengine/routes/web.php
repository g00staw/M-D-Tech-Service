<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/selectlogin', function () {
    return view('selectlogin');
});

Route::get('/dashboard-client', function () {
    return view('clientdashboard');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


