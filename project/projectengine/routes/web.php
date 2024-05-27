<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

// Strona główna
Route::get('/', function () {
    return view('auth.selectlogin');
});

Route::get('/user-dashboard', function () {
    return view('user.clientdashboard');
})->name('userdashboard');

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->name('admindashboard');

Route::get('/employee-dashboard', function () {
    return view('employee.dashboard');  
})->name('employeedashboard');

Route::controller(UserDashboardController::class)->group(function(){
    Route::get('/userdashboard','showDashboard')->name('userdashboard');
    Route::get('/userdashboard/devices', 'showUserDevices')->name('userdashboard.devices')->middleware('auth');
    Route::get('/userdashboard/device/add','addUserDevice')->name('userdashboard.add.device')->middleware('auth');
    Route::post('/userdashboard/device/add/from-service', 'addDeviceToUser')->name('userdashboard.add.device.fs')->middleware('auth');
    Route::post('/userdashboard/device/add/from-outside', 'addDevice')->name('userdashboard.add.device.fo')->middleware('auth');
    Route::get('/userdashboard/device/{id}', 'findDevice')->name('userdashboard.device')->middleware('auth');
    Route::get('/userdashboard/repairs', 'showRepairs')->name('userdashboard.repairs')->middleware('auth');
    Route::get('/userdashboard/repair/add', 'showRepairForm')->name('userdashboard.add.repair')->middleware('auth');
    Route::post('/userdashboard/repair/add', 'addUserRepair')->name('userdashboard.add.repair.store')->middleware('auth');
    Route::get('/userdashboard/repair/{id}', 'showRepair')->name('userdashboard.repair')->middleware('auth');
    Route::post('/userdashboard/repair/{id}', 'payForRepair')->name('userdashboard.repair.payment')->middleware('auth');
    Route::get('/userdashboard/add/addReview', 'showReviewForm')->name('userdashboard.addreview')->middleware('auth');
    Route::post('/userdashboard/add/addReview', 'addReview')->name('userdashboard.add.review')->middleware('auth');
    Route::get('/userdashboard/profile', 'showProfile')->name('userdashboard.profile')->middleware('auth');
    Route::post('/userdashboard/profile/change-password', 'updatePassword')->name('userdashboard.profile.psschange')->middleware('auth');
    Route::post('/userdashboard/profile/change-email', 'updateEmail')->name('userdashboard.profile.emchange')->middleware('auth');
    Route::post('/userdashboard/profile/change-photo', 'updatePhoto')->name('userdashboard.profile.phchange')->middleware('auth');
});

Route::controller(AdminDashboardController::class)->group(function(){
    Route::get('/admindashboard', 'showDashboard')->name('admindashboard')->middleware('admin');
    Route::get('/admindashboard/employees', 'showEmployees')->name('admindashboard.employees')->middleware('admin');
    Route::get('/admindashboard/employee/{id}', 'employeeinfo')->name('admindashboard.employeeinfo')->middleware('admin');
    Route::post('/admindashboard/employee/{id}', 'updateEmployeeSalary')->name('admindashboard.employee.updatesalary')->middleware('admin');
    Route::post('/admindashboard/employees', 'assignRepairToEmployee')->name('admindashboard.employees.assignRepairToEmployee')->middleware('admin');
    Route::delete('/admindashboard/employee/{id}', 'deleteEmployee')->name('admindashboard.employee.delete');
    Route::get('/admindashboard/services', 'displayServices')->name('admindashboard.services')->middleware('admin');
    Route::post('/admindashboard/services', 'editService')->name('admindashboard.edit.service')->middleware('admin');
    Route::get('/admindashboard/service/add', 'showFormService')->name('admindashboard.addform.service')->middleware('admin');
    Route::post('/admindashboard/service/add', 'addService')->name('admindashboard.add.service')->middleware('admin');
    Route::get('/admindashboard/service/remove', 'showRemoveFormService')->name('admindashboard.removeForm.service')->middleware('admin');
    Route::delete('/admindashboard/service/remove', 'removeService')->name('admindashboard.remove.service')->middleware('admin');
    Route::get('/admindashboard/add/employee', 'addEmployeeForm')->name('admindashboard.employee.addForm')->middleware('admin');
    Route::post('/admindashboard/add/employee', 'addEmployee')->name('admindashboard.add.employee')->middleware('admin');
    Route::get('/admindashboard/devices', 'showDevices')->name('admindashboard.devices')->middleware('admin');
    Route::delete('/admindashboard/devices', 'deleteDevice')->name('admindashboard.device.delete')->middleware('admin');
    Route::get('/admindashboard/repairs', 'showRepairs')->name('admindashboard.repairs')->middleware('admin');
    Route::get('/admindashboard/finanse', 'showFinanse')->name('admindashboard.finanse')->middleware('admin');
});

Route::controller(EmployeeDashboardController::class)->group(function(){
    Route::get('/employeedashboard', 'showDashboard')->name('employeedashboard')->middleware('employee');
    Route::post('/employeedashboard', 'assignRepairToEmployee')->name('employeedashboard.assignRepairToEmployee')->middleware('admin');
    Route::get('/employeedashboard/repair/{id}', 'showRepair')->name('employeedashboard.repair')->middleware('admin');
    Route::post('/employeedashboard/repair/{id}/change-status', 'changeRepairStatus')->name('employeedashboard.repair.changeStatus')->middleware('admin');
    Route::post('/employeedashboard/repair/{id}/add-note', 'addRepairNote')->name('employeedashboard.repair.addRepairNote')->middleware('admin');
    Route::post('/employeedashboard/repair/{id}/add-payment', 'addNewPayment')->name('employeedashboard.repair.addNewPayment')->middleware('admin');
});

/* Route::get('/userdashboard/devices', [UserDashboardController::class, 'showUserDevices'])->name('userdashboard.devices');

Route::get('/userdashboard', [UserDashboardController::class, 'showDashboard'])->name('userdashboard'); */




Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegisterForm')->name('registerForm');
    Route::post('/register', 'register')->name('register');
});



/* // Logowanie, wylogowywanie
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout'); */


