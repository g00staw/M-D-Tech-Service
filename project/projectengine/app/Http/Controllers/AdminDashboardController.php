<?php

namespace App\Http\Controllers;

use Database\Factories\EmployeeFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Employee;
use App\Models\User;
use Laravel\Ui\AuthCommand;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\Repair;

class AdminDashboardController extends Controller
{
    public function showDashboard()
    {
        $revenueLast7Days = Payment::revenueLast7Days();
        $revenueComparison = Payment::compareRevenueLast7DaysWithPrevious2Weeks();

        $data = Payment::getIncomeForLast7Days();
        $hasData = !empty(array_filter($data['data']));

        $userCount = User::countUsers();
        $employeesCount = Employee::countEmployees();

        $nonCompletedRepairsCount = Repair::countNonCompletedRepairs();

        return view('admin.dashboard', ['data' => $data, 'hasData' => $hasData, 'lastWeekIncome' => $revenueLast7Days,
        'comparison' => $revenueComparison, 'numberOfUsers' => $userCount, 'numberOfEmployees' => $employeesCount,
        'numberOfActiveRepairs' => $nonCompletedRepairsCount]);
    }

    public function showEmployees(){
        $employees = Employee::paginate(10);
        foreach ($employees as $employee) {
            $employee->activeRepairsCount = Employee::showActiveRepairsCount($employee->id);
            $employee->completedRepairsThisWeek = Employee::showCompletedRepairs($employee->id, 7);
        }
        return view('admin.employees', ['employees' => $employees]);
    }

    public function employeeinfo($id){
        $employee = Employee::findOrFail($id);

        

        return view('admin.employee', ['employee' => $employee]);
    }
    
}
