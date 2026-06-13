<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationStepMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('register.account')) {
            return redirect()->route('register.account');
        }

        return $next($request);
    }
}