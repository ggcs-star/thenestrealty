<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

            // Employee guard routes
            if ($request->is('employee/*')) {
                return route('employee.login');
            }

            // Default admin login
            return route('login');
        }

        return null;
    }
}
