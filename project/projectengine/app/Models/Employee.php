<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'email'];

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}