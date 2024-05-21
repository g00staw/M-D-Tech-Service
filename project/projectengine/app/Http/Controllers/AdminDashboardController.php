<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Employee;
use App\Models\User;
use Laravel\Ui\AuthCommand;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function showDashboard()
    {
        $data = Payment::getIncomeForLast7Days();
        $hasData = !empty(array_filter($data['data']));

        return view('admin.dashboard', ['data' => $data, 'hasData' => $hasData]);
    }

    public function showEmployees(){
        $employees = Employee::paginate(10);
        return view('admin.employees', ['employees' => $employees]);
    }
}
