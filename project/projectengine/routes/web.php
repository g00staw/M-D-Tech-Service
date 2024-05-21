<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

// Strona główna
Route::get('/', function () {
    return view('welcome');
});

Route::get('/user-dashboard', function () {
    return view('user.clientdashboard');
})->name('userdashboard');

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->name('admindashboard');

Route::get('/employee-dashboard', function () {
    return view('employee.dashboard');
})->name('employee-dashboard');

Route::controller(UserDashboardController::class)->group(function(){
    Route::get('/userdashboard/devices', 'showUserDevices')->name('userdashboard.devices');
    Route::get('/userdashboard','showDashboard')->name('userdashboard');
    Route::get('/userdashboard/device/add','addUserDevice')->name('userdashboard.add.device');
    Route::post('/userdashboard/device/add', 'addDeviceToUser')->name('userdashboard.add.device.store');
    Route::get('/userdashboard/device/{id}', 'findDevice')->name('userdashboard.device');
    Route::get('/userdashboard/repairs', 'showRepairs')->name('userdashboard.repairs');
    Route::get('/userdashboard/repair/add', 'showRepairForm')->name('userdashboard.add.repair');
    Route::post('/userdashboard/repair/add', 'addUserRepair')->name('userdashboard.add.repair.store');
    
});

Route::controller(AdminDashboardController::class)->group(function(){
    Route::get('/admindashboard', 'showDashboard')->name('admindashboard');
    Route::get('/admindashboard/employees', 'showEmployees')->name('admindashboard.employees');
});

/* Route::get('/userdashboard/devices', [UserDashboardController::class, 'showUserDevices'])->name('userdashboard.devices');

Route::get('/userdashboard', [UserDashboardController::class, 'showDashboard'])->name('userdashboard'); */




Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});



/* // Logowanie, wylogowywanie
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout'); */


