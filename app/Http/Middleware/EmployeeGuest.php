<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeGuest
{
    public function handle(Request $request, Closure $next)
    {
        // Agar employee already logged in → dashboard redirect
        if (Auth::guard('employee')->check()) {
            return redirect()->route('dashboard');
        }

        // Admin login ho raha ho to bhi employee login page allow hoga
        return $next($request);
    }
}
