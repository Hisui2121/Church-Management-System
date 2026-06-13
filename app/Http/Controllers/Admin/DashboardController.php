<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Ministry;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\ServiceSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalMembers = Member::count();
        $totalMinistries = Ministry::count();
        $activeAnnouncements = Announcement::where('is_active', true)->count();
        $totalAttendance = Attendance::count();
        $heroesMembers = \App\Models\Member::latest()->take(5)->get();

        // Sidebar Data
        $announcements = Announcement::latest()->take(3)->get();
        $activityLog = AuditLog::latest()->take(4)->get();

        // CAROUSEL DATA: Kukunin ang mga active announcements na may nakalagay na image
        $carouselAnnouncements = Announcement::where('is_active', true)
                                    ->whereNotNull('image_path')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // RAW ATTENDANCE DATA: Ipapasa sa JS para sa dynamic chart filtering
        // Kukunin natin ang attendance pati ang Member Type para malaman kung Guest o hindi
        $rawAttendances = Attendance::with(['member.memberType', 'user'])->get()->map(function($att) {
            $typeName = strtolower($att->member?->memberType->name ?? 'member');
            $isGuest = $att->user?->hasRole('Guest')
                || (!$att->member && $att->user)
                || str_contains($typeName, 'guest')
                || str_contains($typeName, 'visitor');

            return [
                'date' => Carbon::parse($att->date)->format('Y-m-d'),
                'is_guest' => $isGuest
            ];
        });

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalMinistries',
            'activeAnnouncements',
            'totalAttendance',
            'heroesMembers',
            'announcements', 
            'activityLog',
            'carouselAnnouncements',
            'rawAttendances'
        ));
    }

    public function toggleSession(Request $request)
    {
        $validated = $request->validate([
            'session_date' => 'required_if:action,start|nullable|date_format:Y-m-d\TH:i',
            'pastor_id' => 'nullable|exists:users,id',
            'pastor_name' => 'nullable|string|max:255',
            'service_title' => 'nullable|string',
            'verse' => 'nullable|string',
        ]);

        // Check if there's an active session
        $activeSession = ServiceSession::where('is_active', true)->first();

        if ($activeSession) {
            // End the session
            $activeSession->update([
                'is_active' => false,
                'ended_at' => now(),
            ]);

            // Audit log for ending session
            AuditLog::record('Ended', 'service_sessions', $activeSession->id, "Service session ended: {$activeSession->service_title}", 'attendance');

            return back()->with('success', 'Service session ended successfully.');
        } else {
            // Start a new session
            $pastorId = $validated['pastor_id'] ?? null;
            if (!$pastorId && !empty($validated['pastor_name'])) {
                $pastor = \App\Models\User::role('Pastor')->where('name', $validated['pastor_name'])->first();
                $pastorId = $pastor?->id;
            }

            $session = ServiceSession::create([
                'is_active' => true,
                'started_at' => now(),
                'started_by_user_id' => Auth::id(),
                'session_date' => $validated['session_date'] ? Carbon::createFromFormat('Y-m-d\TH:i', $validated['session_date']) : now(),
                'pastor_id' => $pastorId,
                'service_title' => $validated['service_title'] ?? null,
                'verse' => $validated['verse'] ?? null,
            ]);

            AuditLog::record('Started', 'service_sessions', $session->id, "Service session started: {$session->service_title}", 'attendance');

            return back()->with('success', 'Service session started successfully.');
        }
    }
}