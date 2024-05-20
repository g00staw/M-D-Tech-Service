<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Repair;
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
        $user = auth()->user();

        $repairs = $user->repairs()->with('device')->paginate(10);

        return view('user.repairs', ['user' => $user, 'repairs' => $repairs]);
    }

    public function showRepairForm(){
        $devices = auth()->user()->devices->filter(function ($device) {
            
            $ongoingRepairs = $device->repairs->where('status', '!=', 'completed');
            return $ongoingRepairs->isEmpty();
        });
    
        if($devices->isEmpty()){
            return back()->with('error', 'Nie możesz stworzyć nowego zgłoszenia, ponieważ Twoje urządzenie jest aktualnie w naprawie.');
        }

        
    
        return view('user.addrepair', compact('devices'));
    }

    public function addUserRepair(Request $request){
        $title = $request->input('title');
        $description = $request->input('description');
        $device_id = $request->input('device_id');

        $repair = new Repair;
        $repair->device_id = $device_id;
        $repair->user_id = auth()->id();
        $repair->status = 'pending';
        $repair->report_date = now();
        $repair->user_notes = $description;
        $repair->repair_title = $title;
        $repair->employee_id = null;

        $repair->save();

        return redirect('/userdashboard/repairs');
    }
}
