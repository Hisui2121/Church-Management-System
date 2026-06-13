<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MinistriesController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->hasPermission('view_ministries')) {
            abort(403, 'You do not have permission to view ministries.');
        }
        $ministries = Ministry::latest()->paginate(15);
        
        return view('admin.ministries.index', [
            'title' => 'Ministries',
            'ministries' => $ministries,
        ]);
    }

    public function create(): View
    {
        return view('admin.ministries.create', [
            'title' => 'Add Ministry',
        ]);
    }

    public function show(Request $request, Ministry $ministry): View
    {
        if (!auth()->user()->hasPermission('view_ministries')) {
            abort(403, 'You do not have permission to view ministries.');
        }

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'exists:member_statuses,name'],
            'ministry_role' => ['nullable', 'string', 'in:Leader,Member'],
        ]);

        $members = User::with(['memberStatus', 'roles', 'member.ministries'])
            ->whereHas('member.ministries', fn ($ministryQuery) => $ministryQuery->whereKey($ministry->id))
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
            ->when($filters['ministry_role'] ?? null, function ($query, string $role) use ($ministry) {
                // filter by pivot role on member_ministries
                $query->whereHas('member.ministries', function ($mq) use ($ministry, $role) {
                    $mq->whereKey($ministry->id)->where('member_ministries.role', $role);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $availableMembers = User::with(['memberStatus', 'roles'])
            ->whereDoesntHave('member.ministries', fn ($ministryQuery) => $ministryQuery->whereKey($ministry->id))
            ->orderBy('name')
            ->get();

        return view('admin.ministries.show', [
            'title' => 'Assign Members',
            'ministry' => $ministry,
            'members' => $members,
            'availableMembers' => $availableMembers,
            'statuses' => MemberStatus::orderBy('name')->pluck('name'),
            'filters' => $filters,
            'showAddMembers' => $request->boolean('add'),
            'ministryRoles' => ['Leader', 'Member'],
        ]);
    }

    public function assignMember(Request $request, Ministry $ministry, User $user)
    {
        if (!auth()->user()->hasPermission('view_ministries')) {
            abort(403, 'You do not have permission to assign ministry members.');
        }

        $validated = $request->validate([
            'ministry_role' => ['required', 'string', 'in:Leader,Member'],
        ]);

        $member = $this->ensureMemberProfile($user);

        $member->ministries()->syncWithoutDetaching([
            $ministry->id => [
                'role' => $validated['ministry_role'],
                'joined_at' => now()->toDateString(),
            ],
        ]);

        AuditLog::record(
            'Added',
            'member_ministries',
            $member->id,
            "{$user->name} added to {$ministry->name} as {$validated['ministry_role']}"
        );

        return back()->with('success', "{$user->name} was assigned to {$ministry->name}.");
    }

    public function removeMember(Ministry $ministry, User $user)
    {
        if (!auth()->user()->hasPermission('view_ministries')) {
            abort(403, 'You do not have permission to remove ministry members.');
        }

        $member = $user->member;
        $member?->ministries()->detach($ministry->id);

        AuditLog::record(
            'Deleted',
            'member_ministries',
            $member?->id,
            "{$user->name} removed from {$ministry->name}"
        );

        return back()->with('success', "{$user->name} was removed from {$ministry->name}.");
    }

    private function ensureMemberProfile(User $user): Member
    {
        if ($user->member) {
            return $user->member;
        }

        $nameParts = explode(' ', $user->name, 2);
        $member = Member::create([
            'first_name' => $nameParts[0],
            'last_name' => $nameParts[1] ?? '',
            'email' => $user->email,
            'contact_number' => $user->phone,
            'member_status_id' => $user->member_status_id,
            'date_joined' => now(),
        ]);

        $user->update(['member_id' => $member->id]);

        return $member;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:ministries',
            'description' => 'nullable|string',
        ]);

        Ministry::create($validated);
        return redirect()->route('admin.ministries.index')->with('success', 'Ministry created successfully');
    }

    public function edit(Ministry $ministry): View
    {
        return view('admin.ministries.edit', [
            'title' => 'Edit Ministry',
            'ministry' => $ministry,
        ]);
    }

    public function update(Request $request, Ministry $ministry)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:ministries,name,' . $ministry->id,
            'description' => 'nullable|string',
        ]);

        $ministry->update($validated);
        return redirect()->route('admin.ministries.index')->with('success', 'Ministry updated successfully');
    }

    public function destroy(Ministry $ministry)
    {
        $name = $ministry->name;
        $ministry->delete();
        return redirect()->route('admin.ministries.index')->with('success', "Ministry \"$name\" deleted successfully");
    }
}
