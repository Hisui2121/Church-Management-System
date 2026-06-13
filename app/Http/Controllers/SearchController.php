<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Member;
use App\Models\Ministry;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if (empty($query) || strlen($query) < 2) {
            return view('search.index', compact('query', 'results'));
        }

        // Search announcements
        $announcements = Announcement::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Search events
        $events = Event::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Search ministries
        $ministries = Ministry::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Search members (only if user has permission)
        $members = [];
        if (auth()->user()->hasPermission('view_members')) {
            $members = Member::where('full_name', 'like', "%{$query}%")
                ->orWhere('contact_number', 'like', "%{$query}%")
                ->limit(5)
                ->get();
        }

        $results = [
            'announcements' => $announcements,
            'events' => $events,
            'ministries' => $ministries,
            'members' => $members,
        ];

        return view('search.index', compact('query', 'results'));
    }
}
