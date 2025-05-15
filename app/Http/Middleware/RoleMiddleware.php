<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Session::get('logged_in')) {
            return redirect()->route('login.show');
        }

        $userRole = Session::get('role');
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}