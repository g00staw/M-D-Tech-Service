<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'employee_id', 'report_date', 'completion_date', 'repair_notes'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function ratings()
    {
        return $this->hasOne(Rating::class);
    }

    public function payments()
    {
        return $this->hasOne(Payment::class);
    }

    public static function countNonCompletedRepairs()
    {
        return self::where('status', '<>', 'ukończono')->count();
    }

}
