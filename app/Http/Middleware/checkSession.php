<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class checkSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('logged_in')) {
            return redirect()->route('login.show');
        }

        return $next($request);
    }
}