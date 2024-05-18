<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Techservice;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Laravel\Ui\AuthCommand;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function showDashboard()
    {
        // Pobierz wszystkie oceny wraz z danymi użytkowników i napraw
        $ratings = Rating::with('user', 'repair')->paginate(5);

        $services = Techservice::all();

        return view('user.clientdashboard', ['ratings' => $ratings,  'services' => $services]);
    }

    public function showUserDevices()
    {
        $user = auth()->user();

        $devices = Device::where('user_id', $user->id)->paginate(10);

        return view('user.devices', ['user' => $user, 'devices' => $devices]);
    }

    public function addUserDevice(){
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

    public function addDeviceToUser(Request $request){

        $serial_number = $request->input('serialnumber');
        $purchase_date = $request->input('purchase-date');
        $user_id = auth()->id();

        $device = Device::where('serial_number', $serial_number)
                        ->where('purchase_date', $purchase_date)
                        ->first();
        
        if($device == null) {
            return back()->with(['error' => "Nie znaleziono urządzenia o podanym numerze seryjnym i dacie zakupu. {$serial_number}"]);
        }

        if ($device->user_id != null) {
            return back()->with(['error' => 'To urządzenie ma już przypisanego użytkownika.']);
        }

        $device->user_id = $user_id;
        $device->save();

        return back()->with('success', 'Pomyślnie przypisano urządzenie do użytkownika.');
    }

    public function showRepairs(){
        return view('user.repairs');
    }
}
