<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Redirect admins to the admin dashboard
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Fetch active banners
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Fetch active announcements
        $announcements = Announcement::where('is_active', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        // Fetch upcoming events
        $events = Service::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        // Fetch events for this week
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $eventsThisWeek = Service::whereBetween('event_date', [$weekStart, $weekEnd])
            ->orderBy('event_date')
            ->get();

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

        return view('dashboard', compact('banners', 'announcements', 'events', 'eventsThisWeek', 'eventDates'));
    }
}
