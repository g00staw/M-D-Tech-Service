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

    public function displayServices()
    {
        $techservices = Techservice::paginate(10, ['*'], 'services_page');


        return view('admin.services', ['services' => $techservices]);
    }

    public function editService(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'min_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'max_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|string|max:255'
        ]);

        $techservice = Techservice::findOrFail($request->input('service_id'));

        if ($request->input('min_price') > $request->input('max_price')) {
            return back()->with('warning', 'Cena minimalna nie może być większa od maksymalnej.');
        }

        $techservice->title = $request->input('title');
        $techservice->price_min = $request->input('min_price');
        $techservice->price_max = $request->input('max_price');
        $techservice->description = $request->input('description');

        $techservice->save();

        return back()->with('success', 'Pomyślnie zmodyfikowano usługę.');
    }

    public function showFormService()
    {
        return view('admin.addservice');
    }

    public function addService(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'min_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'max_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|string|max:255'
        ]);

        if ($request->input('min_price') > $request->input('max_price')) {
            return back()->with('warning', 'Cena minimalna nie może być większa od maksymalnej.');
        }


        $techservice = new Techservice();
        $techservice->title = $request->input('title');
        $techservice->price_min = $request->input('min_price');
        $techservice->price_max = $request->input('max_price');
        $techservice->description = $request->input('description');

        $techservice->save();

        return redirect()->route('admindashboard.services')->with('success', 'Dodano usługę.');
    }

    public function showRemoveFormService()
    {
        $techservices = Techservice::all();


        return view('admin.removeservice', ['services' => $techservices]);
    }

    public function removeService(Request $request)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->withErrors(['msg' => 'Musisz być zalogowany jako admin, aby usunąć pracownika.']);
        }

        $techservice = Techservice::findOrFail($request->input('service_id'));
        $techservice->delete();

        return redirect()->route('admindashboard.services')->with('success', 'Usunięto usługę.');
    }

    public function addEmployeeForm()
    {
        return view('admin.addemployee');
    }

    public function addEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:6|confirmed',
            'salary' => 'required|integer|min:0'
        ]);

        Employee::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'salary' => $request->input('salary'),
        ]);

        return redirect()->route('admindashboard.employees')->with('success', 'Pracownik został pomyślnie dodany.');
    }
    public function showDevices()
    {
        $devices = Device::paginate(10, ['*'], 'device_page');

        return view('admin.devices', ['devices' => $devices]);
    }

    public function deleteDevice(Request $request)
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

        $activeRepair = Repair::where('device_id', $request->input('device_id'))->where('status', '!=', 'ukończono')->first();
        if ($activeRepair) {
            return redirect()->back()->withErrors(['device' => 'Urządzenie jest aktualnie naprawiane i nie może być usunięte.']);
        }

        $device = Device::findOrFail($request->input('device_id'));
        $device->delete();

        return redirect()->route('admindashboard.devices')->with('success', 'Urządzenie zostało pomyślnie usunięte.');
    }

    public function showRepairs()
    {
        $repairs = Repair::paginate(10, ['*'], 'repair_page');

        return view('admin.repairs', ['repairs' => $repairs]);
    }

    public function showUsers()
    {
        $users = User::paginate(10, ['*'], 'user');

        return view('admin.repairs', ['users' => $users]);
    }



}
