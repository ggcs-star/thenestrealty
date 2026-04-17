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
        // dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required|string|min:6|max:50',
        ]);
// dd($credentials);
        $ipKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($ipKey, 3)) {

            $seconds = RateLimiter::availableIn($ipKey); 

            throw ValidationException::withMessages([
                'email' => "Too many attempts. Try again in $seconds seconds.",
            ]);
        }

        RateLimiter::hit($ipKey, 60);


        $employee = Employee::select('id', 'email', 'password', 'status')
            ->where('email', $request->email)
            ->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {

            usleep(300000); 
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        if ($employee->status === 'inactive') {

            $request->session()->invalidate();

            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact admin support.',
            ])->onlyInput('email');
        }

        Auth::guard('employee')->login($employee);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }



    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
