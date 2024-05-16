<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

// Strona główna
Route::get('/', function () {
    return view('welcome');
});

Route::get('/userdashboard', function () {
    return view('user.clientdashboard');
})->name('userdashboard');

Route::get('/userdashboard/devices', [UserDashboardController::class, 'showUserDevices'])->name('userdashboard.devices');

Route::get('/userdashboard', [UserDashboardController::class, 'showDashboard'])->name('userdashboard');



// Panel urządzeń dla użytkownika
Route::middleware(['auth:user'])->group(function () {
    Route::get('/userdashboard/devices', [UserDashboardController::class, 'showUserDevices'])->name('userdashboard.devices');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});



/* // Logowanie, wylogowywanie
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout'); */


