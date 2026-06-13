<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\MemberStatus;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MembersController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'exists:member_statuses,name'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'ministry' => ['nullable', 'string', 'exists:ministries,name'],
        ]);

        $members = User::with(['memberStatus', 'roles', 'member.ministries'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, function ($query, string $status) {
                $query->whereHas('memberStatus', fn ($statusQuery) => $statusQuery->where('name', $status));
            })
            ->when($filters['role'] ?? null, function ($query, string $role) {
                $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('name', $role));
            })
            ->when($filters['ministry'] ?? null, function ($query, string $ministry) {
                $query->whereHas('member.ministries', fn ($ministryQuery) => $ministryQuery->where('name', $ministry));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = MemberStatus::orderBy('name')->pluck('name');
        $roles = Role::orderBy('name')->pluck('name');
        $ministries = Ministry::orderBy('name')->pluck('name');

        return view('admin.members.index', [
            'title' => 'Members',
            'members' => $members,
            'statuses' => $statuses,
            'roles' => $roles,
            'ministries' => $ministries,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.members.create', [
            'title' => 'Add Member',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|string',
            'street' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city' => 'nullable|string',
            'member_status' => 'nullable|string',
            'member_type' => 'nullable|string',
            'baptism_status' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'ministry_interest' => 'nullable|string',
        ]);

        if ($validated['member_status'] ?? null) {
            $status = \App\Models\MemberStatus::where('name', $validated['member_status'])->first();
            $validated['member_status_id'] = $status?->id;
            unset($validated['member_status']);
        }

        $member = \App\Models\User::create($validated);
        AuditLog::record('Created', 'users', $member->id, "Member '{$member->name}' created");

        return redirect()->route('admin.members.show', $member->id)->with('success', 'Member created successfully');
    }

    public function show($id): View
    {
        $member = \App\Models\User::findOrFail($id);
        return view('admin.members.show', [
            'title' => 'Member Details',
            'member' => $member,
        ]);
    }

    public function edit($id): View
    {
        $member = \App\Models\User::findOrFail($id);
        return view('admin.members.edit', [
            'title' => 'Edit Member',
            'member' => $member,
        ]);
    }

    public function update(Request $request, $id)
    {
        $member = \App\Models\User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|string',
            'street' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city' => 'nullable|string',
            'member_status' => 'nullable|string',
            'member_type' => 'nullable|string',
            'baptism_status' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'ministry_interest' => 'nullable|string',
        ]);

        if ($validated['member_status'] ?? null) {
            $status = \App\Models\MemberStatus::where('name', $validated['member_status'])->first();
            $validated['member_status_id'] = $status?->id;
            unset($validated['member_status']);
        }

        $member->update($validated);
        AuditLog::record('Updated', 'users', $member->id, "Member '{$member->name}' updated");

        return redirect()->route('admin.members.show', $id)->with('success', 'Member updated successfully');
    }

    public function destroy($id)
    {
        $member = \App\Models\User::findOrFail($id);
        $memberName = $member->name;
        $member->delete();
        AuditLog::record('Deleted', 'users', $id, "Member '{$memberName}' deleted");

        return redirect()->route('admin.members.index')->with('success', "Member \"$memberName\" deleted successfully");
    }
}
