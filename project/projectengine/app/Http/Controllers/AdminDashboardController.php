<?php

namespace App\Http\Controllers;

use App\Models\Techservice;
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
use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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

        return view('admin.dashboard', [
            'data' => $data,
            'hasData' => $hasData,
            'lastWeekIncome' => $revenueLast7Days,
            'comparison' => $revenueComparison,
            'numberOfUsers' => $userCount,
            'numberOfEmployees' => $employeesCount,
            'numberOfActiveRepairs' => $nonCompletedRepairsCount
        ]);
    }

    public function showEmployees()
    {
        $repairs = Repair::where('status', 'zgłoszone')
            ->whereNull('employee_id')
            ->paginate(5, ['*'], 'repairs_page');
        $employees = Employee::paginate(10, ['*'], 'employees_page');

        foreach ($employees as $employee) {
            $employee->activeRepairsCount = Employee::showActiveRepairsCount($employee->id);
            $employee->completedRepairsThisWeek = Employee::showCompletedRepairs($employee->id, 7);
        }



        $nonCompletedRepairsCount = Repair::countNonCompletedRepairs();

        return view('admin.employees', ['employees' => $employees, 'numberOfActiveRepairs' => $nonCompletedRepairsCount, 'repairs' => $repairs]);
    }

    public function employeeinfo($id)
    {
        $employee = Employee::findOrFail($id);
        $activeRepairs = Employee::showActiveRepairsCount($id);
        $completedRepairsThisWeek = Employee::showCompletedRepairs($id, 7);
        $completedRepairsThisMonth = Employee::showCompletedRepairs($id, 30);

        return view('admin.employee', [
            'employee' => $employee,
            'activeRepairs' => $activeRepairs,
            'compRepTWeek' => $completedRepairsThisWeek,
            'compRepTMonth' => $completedRepairsThisMonth
        ]);
    }

    public function updateEmployeeSalary(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'salary' => 'required|numeric|min:0',
        ]);

        $employee->salary = $request->input('salary');
        $employee->save();

        return back()->with('success', 'Pomyślnie zmieniono pensje.');
    }

    public function assignRepairToEmployee(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric|min:0',
            'repair_id' => 'required|numeric|min:0',
        ]);

        $repair = Repair::findOrFail($request->input('repair_id'));

        $repair->employee_id = $request->input('employee_id');
        $repair->save();

        return redirect()->route('admindashboard.employees')->with('success', 'Pomyślnie przypisano pracownika do naprawy.');
    }


    public function deleteEmployee(Request $request, $id)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Musisz być zalogowany jako admin, aby usunąć pracownika.']);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->input('password'), Auth::guard('admin')->user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Niepoprawne hasło']);
        }

        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admindashboard.employees')->with('success', 'Pracownik został pomyślnie usunięty.');
    }

    public function displayServices(){
        $techservices = Techservice::paginate(10, ['*'], 'services_page');


        return view('admin.services', ['services' => $techservices]);
    }

    public function editService(Request $request){
        
    }



}
