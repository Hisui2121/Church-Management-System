<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Example future data
        $announcements = [];
        $events = [];
        $attendance = 0;

        return view('dashboard', compact(
            'announcements',
            'events',
            'attendance'
        ));
    }
}