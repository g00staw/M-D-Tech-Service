<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class EnsureUserIsEmployee
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('employee')->check()) {
            abort(403, 'Odmowa dostępu. Musisz być pracownikiem aby otrzymać dostęp do tej strony.');
        }

        return $next($request);
    }
}
