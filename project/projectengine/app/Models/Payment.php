<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'repair_id', 'amount', 'payment_date', 'status', 'payment_method'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    public static function getIncomeForLast7Days()
    {
        $labels = [];
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $income = DB::table('payments')
                ->whereDate('payment_date', $date)
                ->where('status', 'completed')
                ->sum('amount');

            array_push($labels, $date);
            array_push($data, $income);
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public static function revenueLast7Days()
    {
        $last7Days = Carbon::now()->subDays(7);

        return self::where('status', 'completed')
            ->where('payment_date', '>=', $last7Days)
            ->sum('amount');
    }

    /**
     * Compare the revenue from the last 7 days with the revenue from the previous 2 weeks.
     *
     * @return array
     */
    public static function compareRevenueLast7DaysWithPrevious2Weeks()
    {
        $last7Days = Carbon::now()->subDays(7);
        $previous14DaysStart = Carbon::now()->subDays(21);
        $previous14DaysEnd = Carbon::now()->subDays(8);

        $revenueLast7Days = self::where('status', 'completed')
            ->where('payment_date', '>=', $last7Days)
            ->sum('amount');

        $revenuePrevious2Weeks = self::where('status', 'completed')
            ->whereBetween('payment_date', [$previous14DaysStart, $previous14DaysEnd])
            ->sum('amount');

        $difference = $revenueLast7Days - $revenuePrevious2Weeks;
        $percentageChange = $revenuePrevious2Weeks != 0
            ? ($difference / $revenuePrevious2Weeks) * 100
            : ($revenueLast7Days > 0 ? 100 : 0);

        return [
            'revenue_last_7_days' => $revenueLast7Days,
            'revenue_previous_2_weeks' => $revenuePrevious2Weeks,
            'difference' => $difference,
            'percentage_change' => $percentageChange
        ];
    }

   
}