<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'employee_id', 'subject', 'problem_description', 'status', 'creation_date', 'closing_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function messages()
    {
        return $this->hasMany(Ticketsmessage::class);
    }
}