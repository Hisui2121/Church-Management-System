<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AuditLog;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->hasPermission('view_announcements')) {
            abort(403, 'You do not have permission to view announcements.');
        }
        // If user is admin, show admin view with edit/delete actions
        if (auth()->user()->isAdmin()) {
            $announcements = Announcement::with('creator')
                ->latest('published_at')
                ->paginate(15);
            return view('admin.announcements.index', [
                'title' => 'Announcements',
                'announcements' => $announcements,
                'isAdmin' => true,
            ]);
        }

        // For regular users (members), show read-only view
        $announcements = Announcement::where('is_active', true)
            ->latest('published_at')
            ->paginate(15);
        return view('announcements.index', [
            'announcements' => $announcements,
            'isAdmin' => false,
        ]);
    }

    public function create(): View
    {
        return view('admin.announcements.create', [
            'title' => 'Create Announcement',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['created_by'] = auth()->id();
        $announcement = Announcement::create($validated);

        // Log to audit trail
        AuditLog::record('Created', 'announcements', $announcement->id, "Announcement '{$announcement->title}' created");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully');
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', [
            'title' => 'Edit Announcement',
            'announcement' => $announcement,
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->image_path);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
            $validated['image_path'] = $imagePath;
        }

        $announcement->update($validated);

        // Log to audit trail
        AuditLog::record('Updated', 'announcements', $announcement->id, "Announcement '{$announcement->title}' updated");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully');
    }

    public function destroy(Announcement $announcement)
    {
        $announcementTitle = $announcement->title;
        $announcementId = $announcement->id;

        if ($announcement->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        // Log to audit trail
        AuditLog::record('Deleted', 'announcements', $announcementId, "Announcement '{$announcementTitle}' deleted");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully');
    }
}
