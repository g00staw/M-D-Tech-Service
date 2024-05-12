<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'email'];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}