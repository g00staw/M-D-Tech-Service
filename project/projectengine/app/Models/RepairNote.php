<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairNote extends Model
{
    use HasFactory;

    protected $table = 'repairsnotes';

    protected $fillable = [
        'repair_id',
        'message_content',
        'sent_date',
    ];

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }
}
