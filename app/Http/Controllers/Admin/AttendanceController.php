<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Member;
use App\Models\ServiceSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $activeSession = ServiceSession::where('is_active', true)->first();

        $attendances = Attendance::with(['member', 'serviceSession', 'recordedBy'])
            ->when($month, fn($query) => $query->whereMonth('date', $month))
            ->when($year, fn($query) => $query->whereYear('date', $year))
            ->latest('date')
            ->paginate(10)
            ->withQueryString();

        $months = collect(range(1, 12))->map(fn($m) => [
            'value' => $m,
            'label' => Carbon::createFromDate(2024, $m, 1)->format('F'),
        ]);

        $currentYear = now()->year;
        $years = collect(range($currentYear - 5, $currentYear + 1));

        return view('admin.attendance.index', [
            'title' => 'Attendance',
            'attendances' => $attendances,
            'activeSession' => $activeSession,
            'months' => $months,
            'years' => $years,
            'month' => (int) $month,
            'year' => (int) $year,
        ]);
    }

    public function create()
    {
        $activeSession = ServiceSession::where('is_active', true)->first();
        if (!$activeSession) {
            return redirect()->route('admin.attendance.index')
                ->with('error', 'Please start a service session before recording attendance.');
        }

        $members = Member::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.attendance.create', [
            'title' => 'Record Attendance',
            'members' => $members,
            'activeSession' => $activeSession,
        ]);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $validated = $request->validated();

        $activeSession = ServiceSession::where('is_active', true)->first();
        if (!$activeSession) {
            return redirect()->route('admin.attendance.index')
                ->with('error', 'Please start a service session before recording attendance.');
        }

        Attendance::create([
            'member_id' => $validated['member_id'],
            'service_session_id' => $activeSession->id,
            'date' => $activeSession->session_date?->toDateString() ?? now()->toDateString(),
            'checked_in_at' => now(),
            'is_present' => $validated['status'] === 'Present',
            'recorded_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded successfully!');
    }
}
