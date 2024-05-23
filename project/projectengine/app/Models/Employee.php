<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Repair;
use Illuminate\Support\Carbon;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public static function countEmployees(){
        return self::count();
    }

    public static function showActiveRepairsCount($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $activeRepairsCount = $employee->repairs()->where('status', '<>', 'ukończono')->count();
        return $activeRepairsCount;
    }

    public static function showCompletedRepairs($employeeId, $endDate)
    {
        $date = Carbon::now()->subDays($endDate);
        
        $employee = Employee::findOrFail($employeeId);

        $completedRepairs = $employee->repairs()
            ->where('status', '=', 'ukończono')
            ->where('completion_date', '>', Carbon::now())  // Zmień na swoją datę
            ->count();

        return $completedRepairs;
    }
}
