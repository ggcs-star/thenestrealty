<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Employee;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class EmployeeAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('employees.login');
    }

    public function login(Request $request)
    {
        // 1. Validate Inputs (More secure rules)
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:6|max:50',
        ]);

        $ipKey = Str::lower($request->email) . '|' . $request->ip();

        // If too many attempts
        if (RateLimiter::tooManyAttempts($ipKey, 3)) {

            $seconds = RateLimiter::availableIn($ipKey); // ⏳ WAIT TIME

            throw ValidationException::withMessages([
                'email' => "Too many attempts. Try again in $seconds seconds.",
            ]);
        }

        // Hit attempt counter
        RateLimiter::hit($ipKey, 60);


        // 2. Fetch employee with limited columns (Faster DB query)
        $employee = Employee::select('id', 'email', 'password', 'status')
            ->where('email', $request->email)
            ->first();

        // 3. Use constant-time password check to prevent timing attacks
        if (!$employee || !Hash::check($request->password, $employee->password)) {

            // Fake delay to slow down brute force (optional but recommended)
            usleep(300000); // 300ms delay

            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        // 4. If employee exists but inactive
        if ($employee->status === 'inactive') {

            // Invalidate session for safety
            $request->session()->invalidate();

            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact admin support.',
            ])->onlyInput('email');
        }

        // 5. Login the employee guard securely
        Auth::guard('employee')->login($employee);

        // 6. Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // 7. Redirect to dashboard
        return redirect()->intended(route('employee.dashboard'));
    }



    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
