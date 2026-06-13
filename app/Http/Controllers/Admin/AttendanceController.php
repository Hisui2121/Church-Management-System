<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Member;
use App\Models\Service;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['member', 'service', 'recordedBy'])
            ->latest('date')
            ->paginate(10);

        return view('admin.attendance.index', [
            'title' => 'Attendance',
            'attendances' => $attendances,
        ]);
    }

    public function create()
    {
        $members = Member::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $services = Service::latest()->get();

        return view('admin.attendance.create', [
            'title' => 'Record Attendance',
            'members' => $members,
            'services' => $services,
        ]);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $validated = $request->validated();

        Attendance::create([
            'member_id' => $validated['member_id'],
            'service_id' => $validated['service_id'],
            'date' => $validated['date'],
            'is_present' => $validated['status'] === 'Present',
            'recorded_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded successfully!');
    }
}
