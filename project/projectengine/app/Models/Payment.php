<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}