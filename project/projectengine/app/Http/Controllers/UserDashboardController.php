<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Repair;
use App\Models\Techservice;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\RepairNote;
use Laravel\Ui\AuthCommand;
use App\Models\Payment;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function showDashboard()
    {
        // Pobierz wszystkie oceny wraz z danymi użytkowników i napraw
        $ratings = Rating::with('user', 'repair')->paginate(5);

        $services = Techservice::all();

        return view('user.clientdashboard', ['ratings' => $ratings, 'services' => $services]);
    }

    public function showUserDevices()
    {
        $user = auth()->user();

        $devices = Device::where('user_id', $user->id)->paginate(10);

        return view('user.devices', ['user' => $user, 'devices' => $devices]);
    }

    public function addUserDevice()
    {
        return view('user.adddevice');
    }

    public function findDevice($id)
    {
        $device = Device::findOrFail($id);

        $months_left = $device->monthsUntilWarrantyExpires();

        return view('user.showdevice', [
            'device' => $device,
            'months_left' => $months_left,
        ]);
    }

    public function addDeviceToUser(Request $request)
    {

        $serial_number = $request->input('serialnumber');
        $purchase_date = $request->input('purchase-date');
        $user_id = auth()->id();

        $device = Device::where('serial_number', $serial_number)
            ->where('purchase_date', $purchase_date)
            ->first();

        if ($device == null) {
            return back()->with(['error' => "Nie znaleziono urządzenia o podanym numerze seryjnym i dacie zakupu. {$serial_number}"]);
        }

        if ($device->user_id != null) {
            return back()->with(['error' => 'To urządzenie ma już przypisanego użytkownika.']);
        }

        $device->user_id = $user_id;
        $device->save();

        return back()->with('success', 'Pomyślnie przypisano urządzenie do użytkownika.');
    }

    public function showRepairs()
    {
        $user = auth()->user();

        // Check if the user has devices
        if ($user->devices->isEmpty()) {
            return back()->with('error', 'Nie masz żadnych urządzeń, ani napraw które można wyświetlić.');
        }

        // Check if the user has repairs
        if ($user->repairs->isEmpty()) {
            return view('user.repairs', ['user' => $user, 'repairs' => null])
                ->with('info', 'Nie masz żadnych napraw.');
        }

        // Retrieve repairs if they exist
        $repairs = $user->repairs()->with('device')->paginate(10);

        return view('user.repairs', ['user' => $user, 'repairs' => $repairs]);
    }


    public function showRepairForm()
    {
        $devices = auth()->user()->devices->filter(function ($device) {

            $ongoingRepairs = $device->repairs->where('status', '!=', 'completed');
            return $ongoingRepairs->isEmpty();
        });

        if ($devices->isEmpty()) {
            return back()->with('error', 'Nie możesz stworzyć nowego zgłoszenia, ponieważ Twoje urządzenie jest aktualnie w naprawie.');
        }



        return view('user.addrepair', compact('devices'));
    }

    public function addUserRepair(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $device_id = $request->input('device_id');

        $repair = new Repair;
        $repair->device_id = $device_id;
        $repair->user_id = auth()->id();
        $repair->status = 'zgłoszone';
        $repair->report_date = now();
        $repair->user_notes = $description;
        $repair->repair_title = $title;
        $repair->employee_id = null;

        $repair->save();

        return redirect('/userdashboard/repairs');
    }

    public function showRepair($repairId)
    {
        $repair = Repair::findOrFail($repairId);

        $notes = RepairNote::where('repair_id', $repairId)->orderBy('sent_date', 'desc')->get();
        $device = $repair->device;

        $payment = Payment::where('repair_id', $repairId)->first();

        return view('user.showrepair', ['repair' => $repair, 'notes' => $notes, 'device' => $device, 'payment' => $payment]);
    }

    public function payForRepair(Request $request)
    {
        $request->validate([
            'repair_id' => 'required|exists:repairs,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);

        $payment = new Payment;
        $payment->user_id = auth()->id();
        $payment->repair_id = $request->repair_id;
        $payment->amount = $request->amount;
        $payment->payment_date = now();
        $payment->status = 'completed';
        $payment->payment_method = $request->payment_method;
        $payment->save();

        return redirect()->back()->with('success', 'Płatność została pomyślnie złożona!');
    }

    public function showReviewForm()
    {
        $repairs = Repair::where('user_id', auth()->id())->where('status', 'ukończono')->get();

        return view('user.giveRate', ['repairs' => $repairs]);
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'repair_id' => 'required|exists:repairs,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);

        $repair = Repair::find($request->repair_id);

        if ($repair->status !== 'ukończono') {
            return redirect()->back()->withErrors(['error' => 'Możesz dodać opinię tylko do zakończonych napraw.']);
        }

        Rating::create([
            'user_id' => Auth::id(),
            'repair_id' => $request->repair_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Opinia została dodana pomyślnie!');
    }

    



}
