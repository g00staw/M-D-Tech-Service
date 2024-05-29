<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Repair;
use App\Models\Techservice;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\RepairNote;
use Laravel\Ui\AuthCommand;
use App\Models\Payment;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\ErrorHandler\Debug;

class UserDashboardController extends Controller
{
    public function showDashboard()
    {
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

        if ($user->devices->isEmpty()) {
            return back()->with('error', 'Nie masz żadnych urządzeń, ani napraw które można wyświetlić.');
        }

        if ($user->repairs->isEmpty()) {
            return view('user.repairs', ['user' => $user, 'repairs' => null])
                ->with('info', 'Nie masz żadnych napraw.');
        }

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

    public function payForRepair(Request $request, $id)
    {
        $request->validate([
            'repair_id' => 'required|exists:repairs,id',
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->user_id = auth()->id();
        $payment->repair_id = $request->repair_id;
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

        $rating = new Rating();
        $rating->user_id = auth()->id();
        $rating->repair_id = $request->input('repair_id');
        $rating->rating = $request->input('rating');
        $rating->review = $request->input('review');
        $rating->save();


        return redirect()->back()->with('success', 'Opinia została dodana pomyślnie!');
    }

    public function addDevice(Request $request)
    {
        $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'serial_number' => ['required', 'string', 'max:9', 'unique:devices,serial_number'],
            'purchase-date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $device = new Device;
        $device->user_id = Auth::id();
        $device->brand = $request->input('brand');
        $device->model = $request->input('model');
        $device->type = $request->input('type');
        $device->serial_number = $request->input('serial_number');
        $device->purchase_date = $request->input('purchase-date');
        $device->end_of_warranty = today()->subYears(2)->format('Y-m-d');
        $device->is_registered = false;
        $device->save();

        return back()->with('success', 'Pomyślnie przypisano urządzenie do użytkownika.');
    }

    public function showProfile(Request $request)
    {
        return view('user.profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

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
            return redirect()->route('userdashboard.profile')->with('error', 'Email jest w użyciu.');
        }


        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'E-mail został pomyślnie zmieniony');
    }



    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['nullable', 'image'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil został pomyślnie zaktualizowany');
    }


    public function showPaymentHistory(){
        $user = Auth::user();
        $pendingPaymentsCount = Payment::where('status', 'pending')->count();
        $payments = Payment::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('user.payments', ['payments' => $payments, 'pendingPaymentsCount' => $pendingPaymentsCount]);
    }





}
