<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class MultiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {

            // Set active guard
            Auth::shouldUse($guard);

            // Get current logged user
            $user = Auth::guard($guard)->user();

            // 🔥 If employee guard & inactive => logout + redirect
            if ($guard === 'employee' && $user->status === 'inactive') {

                Auth::guard('employee')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('employee.login')
                    ->withErrors([
                        'email' => 'Your account is inactive. Please contact admin support.'
                    ]);
            }

            return $next($request);
        }
    }

    // 🔥 Redirect based on guard type
    if (in_array('employee', $guards)) {
        return redirect()->route('employee.login');
    }

    return redirect()->route('login'); // admin login
}

}
