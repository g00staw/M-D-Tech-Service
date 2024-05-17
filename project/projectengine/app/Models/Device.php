<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'serial_number', 'purchase_date','type', 'client_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function monthsUntilWarrantyExpires()
    {
        $end_date = $this->end_of_warranty;
        $today = now();

        return round($today->diffInMonths($end_date, false));
    }
}