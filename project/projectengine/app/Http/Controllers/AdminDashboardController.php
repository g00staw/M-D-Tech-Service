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
use App\Models\Admin;
use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Rules\UniqueEmail;


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

        // Sprawdź, czy pracownik nie jest aktualnie zaangażowany w naprawę
        $activeRepair = Repair::where('employee_id', $id)->where('status', '!=', 'ukończono')->first();
        if ($activeRepair) {
            return back()->with(['error' => 'Pracownik jest aktualnie zaangażowany w naprawę i nie może być usunięty.']);
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
            'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail],
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
            return redirect()->route('admindashboard.devices')->with(['error' => 'Niepoprawne hasło']);
        }

        $deviceId = $request->input('device_id');

        $activeRepair = Repair::where('device_id', $deviceId)->where('status', '!=', 'ukończono')->first();
        if ($activeRepair) {
            return redirect()->route('admindashboard.devices')->with(['error' => 'Urządzenie jest aktualnie naprawiane i nie może być usunięte.']);
        }

        $completedRepair = Repair::where('device_id', $deviceId)->where('status', 'ukończono')->first();
        if ($completedRepair) {
            $payment = Payment::where('repair_id', $completedRepair->id)->where('status', 'completed')->first();
            if (!$payment) {
                return redirect()->route('admindashboard.devices')->with(['error' => 'Naprawa urządzenia została ukończona, ale nie jest opłacona. Urządzenie nie może być usunięte.']);
            }
        }

        $device = Device::findOrFail($deviceId);

        $device->user_id = null;
        $device->save();

        Repair::where('device_id', $device->id)->where('status', 'ukończono')->update(['user_id' => null]);

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

    public function showFinanse()
    {
        $payments = Payment::paginate(10, ['*'], 'payment_page');

        $revenueLast7Days = Payment::revenueLast7Days();
        $revenueComparison = Payment::compareRevenueLast7DaysWithPrevious2Weeks();

        $data = Payment::getIncomeForLast7Days();
        $hasData = !empty(array_filter($data['data']));

        $revenueLast30Days = Payment::revenueLast30Days();

        $data2 = Payment::getIncomeForLast30Days();
        $hasData2 = !empty(array_filter($data2['data2']));




        return view('admin.finanse', [
            'payments' => $payments,
            'data' => $data,
            'data2' => $data2,
            'hasData' => $hasData,
            'hasData2' => $hasData2,
            'lastWeekIncome' => $revenueLast7Days,
            'comparison' => $revenueComparison,
            'lastMonthIncome' => $revenueLast30Days,
        ]);
    }

    public function showProfile(Request $request)
    {
        return view('admin.profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Hasło zostało pomyślnie zmienione');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if (
            User::where('email', $request->email)->exists() ||
            Admin::where('email', $request->email)->exists() ||
            Employee::where('email', $request->email)->exists()
        ) {
            return redirect()->route('admindashboard.profile')->with('error', 'Email jest w użyciu.');
        }


        $user = Auth::guard('admin')->user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'E-mail został pomyślnie zmieniony');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['nullable', 'image'],
        ]);

        $user = Auth::guard('admin')->user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil został pomyślnie zaktualizowany');
    }



}
