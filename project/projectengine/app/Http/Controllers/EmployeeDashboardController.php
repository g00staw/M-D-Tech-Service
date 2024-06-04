<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Repair;
use App\Models\Device;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Admin;
use Laravel\Ui\AuthCommand;
use App\Models\Rating;
use App\Models\RepairNote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{

    public function showDashboard()
    {

        $employeeID = Auth::guard('employee')->user()->id;

        $nonCompletedRepairsCount = Repair::countNonCompletedRepairs();
        $reportedRepairs = Repair::countReportedRepairs();

        $unfinishedRepairs = Repair::where('employee_id', $employeeID)->whereNot('status', 'ukończono')->get();

        $numberOfUnfinishedRepairs = $unfinishedRepairs->count();

        $repairs = Repair::where('status', 'zgłoszone')
            ->whereNull('employee_id')
            ->paginate(5, ['*'], 'repairs_page');

        $yourRepairs = Repair::whereNot('status', 'ukończono')
            ->where('employee_id', $employeeID)
            ->paginate(5, ['*'], 'yourrepairs_page');


        return view('employee.dashboard', [
            'numberOfActiveRepairs' => $nonCompletedRepairsCount,
            'numberOfUnfinishedRepairs' => $numberOfUnfinishedRepairs,
            'reportedRepairs' => $reportedRepairs,
            'repairs' => $repairs,
            'yourrepairs' => $yourRepairs
        ]);
    }

    public function assignRepairToEmployee(Request $request)
    {
        $request->validate([
            'repair_id' => 'required|numeric|min:0',
        ]);

        $employeeID = Auth::guard('employee')->user()->id;

        $repair = Repair::find($request->input('repair_id'));
        if (!$repair) {
            return redirect()->route('employeedashboard')->withErrors(['repair_id' => 'Niepoprawne ID naprawy']);
        }

        $repair->status = 'przyjęte';
        $repair->employee_id = $employeeID;
        $repair->save();

        return redirect()->route('employeedashboard')->with('success', 'Pomyślnie przypisano pracownika do naprawy.');
    }

    public function showRepair($id)
    {

        $repair = Repair::findOrFail($id);

        $notes = RepairNote::where('repair_id', $id)->orderBy('sent_date', 'desc')->get();
        $device = $repair->device;

        return view('employee.repair', ['repair' => $repair, 'notes' => $notes, 'device' => $device]);
    }

    public function changeRepairStatus(Request $request, $repairId){
        $repair = Repair::findOrFail($repairId);

        $repair->status = $request->input('status');
        $repair->save();

        return redirect()->back()->with('success', 'Zmieniono status naprawy.');
    }

    public function addRepairNote(Request $request, $repairId)
    {
        $request->validate([
            'message_content' => 'required|string',
        ]);

        $note = new RepairNote;
        $note->repair_id = $repairId;
        $note->message_content = $request->input('message_content');
        $note->sent_date = now();

        $note->save();

        return redirect()->back()->with('success', 'Notatka została pomyślnie dodana.');
    }

    public function addNewPayment(Request $request, $repairId)
    {
        $request->validate([
            'final_price' => 'required|numeric|between:0,9999999999.99',
            'warranty_renewal' => 'required|integer|between:0,5',
        ]);
    
        $newWarranty = (int) $request->input('warranty_renewal'); // Explicitly cast to integer
    
        $repair = Repair::findOrFail($repairId);
        $repair->status = 'ukończono';
        $repair->completion_date = today();
        $repair->save();
    
        $deviceID = $repair->device_id;
        $device = Device::findOrFail($deviceID);
        $device->is_registered = true;
        $device->end_of_warranty = today()->addYears($newWarranty); // Now $newWarranty is an integer
        $device->save();
    
        $payment = new Payment;
        $payment->user_id = $request->input('user_id');
        $payment->repair_id = $repairId;
        $payment->amount = $request->input('final_price');
        $payment->status = 'pending';
        $payment->payment_method = null;
        $payment->payment_date = null;
        $payment->save();
    
        return redirect()->route('employeedashboard')->with('success', 'Pomyślnie zakończono naprawę.');
    }
    


    public function showProfile(Request $request)
    {
        return view('employee.profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user =  Auth::guard('employee')->user();

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
            return redirect()->route('employeedashboard.profile')->with('error', 'Email jest w użyciu.');
        }


        $user =  Auth::guard('employee')->user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'E-mail został pomyślnie zmieniony');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['nullable', 'image'],
        ]);

        $user =  Auth::guard('employee')->user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        return back()->with('success', 'Profil został pomyślnie zaktualizowany');
    }



}
