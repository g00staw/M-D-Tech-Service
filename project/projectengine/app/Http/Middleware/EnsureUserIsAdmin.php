<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class EnsureUserIsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Odmowa dostępu. Musisz być administratorem aby otrzymać dostęp do tej strony.');
        }

        return $next($request);
    }
}
