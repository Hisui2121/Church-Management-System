<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceSession;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceSessionsController extends Controller
{
    public function index()
    {
        $sessions = ServiceSession::with('startedBy', 'pastor')
            ->orderBy('session_date', 'desc')
            ->paginate(15);

        return view('admin.attendance.sessions', compact('sessions'));
    }

    public function create()
    {
        $pastors = User::role('Pastor')->get();
        return view('admin.attendance.sessions-create', compact('pastors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_date' => 'required|date_format:Y-m-d\TH:i',
            'pastor_id' => 'nullable|exists:users,id',
            'pastor_name' => 'nullable|string|max:255',
            'service_title' => 'required|string|max:255',
            'verse' => 'nullable|string|max:255',
        ]);

        $pastorId = $validated['pastor_id'] ?? null;
        if (!$pastorId && !empty($validated['pastor_name'])) {
            $pastor = User::role('Pastor')->where('name', $validated['pastor_name'])->first();
            $pastorId = $pastor?->id;
        }

        // Create and immediately activate the session (for attendance page start action)
        $session = ServiceSession::create([
            'is_active' => true,
            'started_at' => now(),
            'started_by_user_id' => auth()->id(),
            'session_date' => Carbon::createFromFormat('Y-m-d\TH:i', $validated['session_date']),
            'pastor_id' => $pastorId,
            'service_title' => $validated['service_title'],
            'verse' => $validated['verse'] ?? null,
        ]);

        // Record audit log for starting a session
        AuditLog::record('Started', 'service_sessions', $session->id, "Service session started: {$session->service_title}", 'attendance');

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Service session started successfully!');
    }

    public function edit(ServiceSession $session)
    {
        $pastors = User::role('Pastor')->get();
        return view('admin.attendance.sessions-edit', compact('session', 'pastors'));
    }

    public function update(Request $request, ServiceSession $session)
    {
        $validated = $request->validate([
            'session_date' => 'required|date_format:Y-m-d H:i',
            'pastor_id' => 'nullable|exists:users,id',
            'service_title' => 'required|string|max:255',
            'verse' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $session->update([
            'session_date' => Carbon::createFromFormat('Y-m-d H:i', $validated['session_date']),
            'pastor_id' => $validated['pastor_id'] ?? null,
            'service_title' => $validated['service_title'],
            'verse' => $validated['verse'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.attendance.sessions.index')
            ->with('success', 'Service session updated successfully.');
    }

    public function destroy(ServiceSession $session)
    {
        $session->delete();
        return back()->with('success', 'Service session deleted successfully.');
    }
}
