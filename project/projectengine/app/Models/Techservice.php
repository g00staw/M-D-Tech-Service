<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Techservice extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'title', 'description', 'price_min', 'price_max'];
}
