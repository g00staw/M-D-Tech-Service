<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Repair;
use App\Models\Employee;
use App\Models\Payment;
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

        $unfinishedRepairs = Repair::where('employee_id', $employeeID)->where('status', '!=', 'ukończono')->get();

        $numberOfUnfinishedRepairs = $unfinishedRepairs->count();

        $repairs = Repair::where('status', 'zgłoszone')
            ->whereNull('employee_id')
            ->paginate(5, ['*'], 'repairs_page');

        $yourRepairs = Repair::whereNot('status', 'ukończone')
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

        // Sprawdź, czy naprawa o podanym repair_id istnieje w bazie danych
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

    




}
