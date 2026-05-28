<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show Login Form
    public function create()
    {
        return view('auth.login');
    }

    // Login User
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            AuditLog::record(
                action:         'login',
                tableName:      'users',
                recordId:       Auth::id(),
                description:    'User logged in: ' . Auth::user()->name 
            );

            return redirect()->route('dashboard')
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->onlyInput('email');
    }

    // Logout User
    public function destroy(Request $request)
    {
        AuditLog::record(
            action:         'logout',
            tableName:      'users',
            recordId:       Auth::id(),
            description:    'User logged out: ' . Auth::user()->name
        );
        
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}