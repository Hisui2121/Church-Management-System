<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\AuditLog;
use Illuminate\View\View;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->hasPermission('view_events')) {
            abort(403, 'You do not have permission to view events.');
        }
        // If user is admin, show admin view with edit/delete actions
        if (auth()->user()->isAdmin()) {
            $events = Service::latest()->paginate(15);
            return view('admin.events.index', [
                'title' => 'Events',
                'events' => $events,
                'isAdmin' => true,
            ]);
        }

        // For regular users (members), show read-only view
        $events = Service::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->paginate(15);
        return view('events.index', [
            'events' => $events,
            'isAdmin' => false,
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'title' => 'Add Event',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $imagePath;
        }

        $event = Service::create($validated);

        // Log to audit trail
        AuditLog::record('Created', 'services', $event->id, "Event '{$event->name}' created");

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    public function edit(Service $event): View
    {
        return view('admin.events.edit', [
            'title' => 'Edit Event',
            'event' => $event,
        ]);
    }

    public function update(Request $request, Service $event)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image_path);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $imagePath;
        }

        $event->update($validated);

        // Log to audit trail
        AuditLog::record('Updated', 'services', $event->id, "Event '{$event->name}' updated");

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    public function destroy(Service $event)
    {
        $eventName = $event->name;
        $eventId = $event->id;
        $event->delete();

        // Log to audit trail
        AuditLog::record('Deleted', 'services', $eventId, "Event '{$eventName}' deleted");

        return redirect()->route('admin.events.index')->with('success', "Event \"$eventName\" deleted successfully");
    }
}
