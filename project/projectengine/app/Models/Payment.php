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
}