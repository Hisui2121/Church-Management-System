<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Attendance;
use App\Models\Service;
use App\Models\ServiceSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect admins to the admin dashboard
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Fetch active banners
        $banners = Banner::where('is_active', true)->orderBy('order')->get();

        // Fetch active announcements
        $announcements = Announcement::where('is_active', true)->latest('published_at')->take(6)->get();

        // Fetch upcoming events from Service table
        $events = Service::where('event_date', '>=', now())->orderBy('event_date')->take(5)->get();

        // Fetch events for this week
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $eventsThisWeek = Service::whereBetween('event_date', [$weekStart, $weekEnd])->orderBy('event_date')->get();

        // Get event dates for calendar highlighting
        $eventDates = Service::whereNotNull('event_date')
            ->select('event_date')
            ->distinct()
            ->get()
            ->map(function ($event) {
                return $event->event_date->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        // Active service session (if any)
        $activeSession = ServiceSession::with('pastor')
            ->where('is_active', true)
            ->first();

        // Whether the current authenticated user has checked into the active session
        $hasCheckedInSession = false;
        if ($activeSession && Auth::check()) {
            $hasCheckedInSession = Attendance::where('user_id', Auth::id())
                ->where('service_session_id', $activeSession->id)
                ->exists();
        }

        return view('dashboard', compact(
            'banners', 
            'announcements', 
            'events', 
            'eventsThisWeek',
            'eventDates',
            'activeSession',
            'hasCheckedInSession'
        ));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || (!$user->member && !$user->hasRole('Guest'))) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Member profile not found. Cannot check in.'], 422)
                : back()->with('error', 'Member profile not found. Cannot check in.');
        }

        $activeSession = ServiceSession::where('is_active', true)->first();
        if (!$activeSession) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'There is no active service session right now.'], 409)
                : back()->with('error', 'Check-in failed. There is no active service session right now.');
        }

        $alreadyCheckedIn = Attendance::where('user_id', $user->id)
                                      ->where('service_session_id', $activeSession->id)
                                      ->exists();

        if ($alreadyCheckedIn) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'You are already checked in for today.'], 409)
                : back()->with('info', 'You are already checked in for today.');
        }

        Attendance::create([
            'member_id' => $user->member?->id,
            'user_id' => $user->id,
            'service_session_id' => $activeSession->id,
            'date' => Carbon::today(),
            'checked_in_at' => now(),
            'is_present' => true,
            'recorded_by' => $user->id,
        ]);

        return $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Successfully checked in for the service!'])
            : back()->with('success', 'Successfully checked in for the Service!');
    }
}