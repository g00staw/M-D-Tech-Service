<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'serial_number', 'purchase_date', 'problem_description', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
}