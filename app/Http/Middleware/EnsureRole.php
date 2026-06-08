<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Usage in routes:
     *      ->middleware('role:admin')
     *      ->middleware('role:admin,pastor')
     */

    public function handle(Request $request, Closure $next, String ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $roleName = strtolower($user->role->name ?? '');

        foreach ($roles as $role) {
            if ($roleName === strtolower($role)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this page.');
    }
}