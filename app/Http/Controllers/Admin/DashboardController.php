<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ministry;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\auditLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index(): View
    {
        // Get statistics from database
        $totalMembers = User::count();
        $totalMinistries = Ministry::count();
        $activeAnnouncements = Announcement::where('is_active', true)->count();
        $totalAttendance = Attendance::count();
        
        // Get recent members for the Heroes' Members table
        $heroesMembers = User::with(['memberStatus', 'roles', 'member.ministries'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Get active announcements for the right panel
        $announcements = Announcement::where('is_active', true)
            ->latest('published_at')
            ->limit(5)
            ->get();
        
        // Get activity log for the right panel
        $activityLog = auditLog::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'totalMembers' => $totalMembers,
            'totalMinistries' => $totalMinistries,
            'activeAnnouncements' => $activeAnnouncements,
            'totalAttendance' => $totalAttendance,
            'heroesMembers' => $heroesMembers,
            'announcements' => $announcements,
            'activityLog' => $activityLog,
        ]);
    }
}
