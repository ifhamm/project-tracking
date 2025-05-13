<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if user is logged in
        if (!Session::get('logged_in')) {
            return redirect()->route('login.show');
        }

        // Check if user has any of the required roles
        $userRole = Session::get('role');
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}