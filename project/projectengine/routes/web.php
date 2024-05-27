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
    Route::get('/userdashboard/devices', 'showUserDevices')->name('userdashboard.devices');
    Route::get('/userdashboard','showDashboard')->name('userdashboard');
    Route::get('/userdashboard/device/add','addUserDevice')->name('userdashboard.add.device');
    Route::post('/userdashboard/device/add', 'addDeviceToUser')->name('userdashboard.add.device.store');
    Route::get('/userdashboard/device/{id}', 'findDevice')->name('userdashboard.device');
    Route::get('/userdashboard/repairs', 'showRepairs')->name('userdashboard.repairs');
    Route::get('/userdashboard/repair/add', 'showRepairForm')->name('userdashboard.add.repair');
    Route::post('/userdashboard/repair/add', 'addUserRepair')->name('userdashboard.add.repair.store');
    Route::get('/userdashboard/repair/{id}', 'showRepair')->name('userdashboard.repair');
    Route::post('/userdashboard/repair/{id}', 'payForRepair')->name('userdashboard.repair.payment');
    Route::get('/userdashboard/add/addReview', 'showReviewForm')->name('userdashboard.addreview')->middleware('auth');
    Route::post('/userdashboard/add/addReview', 'addReview')->name('userdashboard.add.review');
    
});

Route::controller(AdminDashboardController::class)->group(function(){
    Route::get('/admindashboard', 'showDashboard')->name('admindashboard');
    Route::get('/admindashboard/employees', 'showEmployees')->name('admindashboard.employees');
    Route::get('/admindashboard/employee/{id}', 'employeeinfo')->name('admindashboard.employeeinfo');
    Route::post('/admindashboard/employee/{id}', 'updateEmployeeSalary')->name('admindashboard.employee.updatesalary');
    Route::post('/admindashboard/employees', 'assignRepairToEmployee')->name('admindashboard.employees.assignRepairToEmployee');
    Route::delete('/admindashboard/employee/{id}', 'deleteEmployee')->name('admindashboard.employee.delete');
    Route::get('/admindashboard/services', 'displayServices')->name('admindashboard.services');
    Route::post('/admindashboard/services', 'editService')->name('admindashboard.edit.service');
    Route::get('/admindashboard/service/add', 'showFormService')->name('admindashboard.addform.service');
    Route::post('/admindashboard/service/add', 'addService')->name('admindashboard.add.service');
    Route::get('/admindashboard/service/remove', 'showRemoveFormService')->name('admindashboard.removeForm.service');
    Route::delete('/admindashboard/service/remove', 'removeService')->name('admindashboard.remove.service');
    Route::get('/admindashboard/add/employee', 'addEmployeeForm')->name('admindashboard.employee.addForm');
    Route::post('/admindashboard/add/employee', 'addEmployee')->name('admindashboard.add.employee');
    Route::get('/admindashboard/devices', 'showDevices')->name('admindashboard.devices');
    Route::delete('/admindashboard/devices', 'deleteDevice')->name('admindashboard.device.delete');
    Route::get('/admindashboard/repairs', 'showRepairs')->name('admindashboard.repairs');
    Route::get('/admindashboard/finanse', 'showFinanse')->name('admindashboard.finanse');
});

Route::controller(EmployeeDashboardController::class)->group(function(){
    Route::get('/employeedashboard', 'showDashboard')->name('employeedashboard');
    Route::post('/employeedashboard', 'assignRepairToEmployee')->name('employeedashboard.assignRepairToEmployee');
    Route::get('/employeedashboard/repair/{id}', 'showRepair')->name('employeedashboard.repair');
    Route::post('/employeedashboard/repair/{id}/change-status', 'changeRepairStatus')->name('employeedashboard.repair.changeStatus');
    Route::post('/employeedashboard/repair/{id}/add-note', 'addRepairNote')->name('employeedashboard.repair.addRepairNote');
    Route::post('/employeedashboard/repair/{id}/add-payment', 'addNewPayment')->name('employeedashboard.repair.addNewPayment');
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


