<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['repair_id', 'rating', 'review'];

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showRatings()
    {
        $ratings = \App\Models\Rating::paginate(10);

        return view('ratings.index', ['ratings' => $ratings]);
    }
}
