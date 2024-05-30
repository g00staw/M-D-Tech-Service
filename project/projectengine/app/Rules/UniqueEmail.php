<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmail implements Rule
{
    public function passes($attribute, $value)
    {
        return !DB::table('employees')->where('email', $value)->exists() &&
               !DB::table('admins')->where('email', $value)->exists() &&
               !DB::table('users')->where('email', $value)->exists();
    }

    public function message()
    {
        return 'Ten email jest w użyciu';
    }
}
