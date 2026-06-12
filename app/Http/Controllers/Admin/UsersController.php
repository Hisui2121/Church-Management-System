<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\AuditLog;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles', 'memberStatus')
            ->latest('created_at')
            ->paginate(15);
        
        return view('admin.users.index', [
            'title' => 'System Users',
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        $roles = Role::all();
        $statuses = MemberStatus::all();
        
        return view('admin.users.create', [
            'title' => 'Create User',
            'roles' => $roles,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8|confirmed',
            'role_name'         => 'required|exists:roles,name',
            'member_status_id'  => 'nullable|exists:member_statuses,id',
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'member_status_id'  => $validated['member_status_id'] ?? null,
        ]);

        //Assign role via Spatie
        $user->assignRole($validated['role_name']);

        if ($validated['role_name'] === 'Member') {
            $nameParts = explode(' ', $user->name, 2);
            $defaultStatus = MemberStatus::where('name', 'Active')->first();

            $member = Member::create([
                'first_name'        => $nameParts[0],
                'last_name'         => $nameParts[1] ?? '',
                'email'             => $user->email,
                'member_status_id'  => $defaultStatus?->id,
                'date_joined'       => now(),
            ]);

            $user->update(['member_id' => $member->id]);
        }

        // Log to audit trail
        AuditLog::record('Created', 'users', $user->id, "User '{$user->name}' ({$validated['role_name']}) created");

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'title' => 'User Details',
            'user' => $user->load('roles', 'memberStatus', 'member'),
        ]);
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $statuses = MemberStatus::all();
        
        return view('admin.users.edit', [
            'title'     => 'Edit User',
            'user'      => $user,
            'roles'     => $roles,
            'statuses'  => $statuses,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_name'         => 'required|exists:roles,name',
            'member_status_id'  => 'nullable|exists:member_statuses,id',
        ]);

        $oldRoleName = $user->getRoleNames()->first() ?? 'Unknown';

        $user->update([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'member_status_id'  => $validated['member_status_id'] ?? null,
        ]);

        //Sync roles via Spatie
        $user->syncRoles([$validated['role_name']]);

        // Handle member creation if changing to Member role
        if ($validated['role_name'] === 'Member' && !$user->member_id) {
            $nameParts = explode(' ', $user->name, 2);
            $defaultStatus = MemberStatus::where('name', 'Active')->first();

            $member = Member::create([
                'first_name'        => $nameParts[0],
                'last_name'         => $nameParts[1] ?? '',
                'email'             => $user->email,
                'member_status_id'  => $defaultStatus?->id,
                'date_joined'       => now(),
            ]);

            $user->update(['member_id' => $member->id]);
        }

        // Log to audit trail
        $newStatusName = $user->memberStatus->name ?? 'None';
        AuditLog::record('Updated', 'users', $user->id, "User '{$user->name}' updated (role: {$oldRoleName} → {$validated['role_name']}, status: {$newStatusName})");

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function changePassword(User $user): View
    {
        return view('admin.users.change-password', [
            'title' => 'Change Password',
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Log to audit trail
        AuditLog::record('Updated', 'users', $user->id, "Password changed for user '{$user->name}'");

        return redirect()->route('admin.users.index')->with('success', 'Password updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting currently logged-in user
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account');
        }

        $userName = $user->name;
        $userId = $user->id;
        $roleName = $user->getRoleNames()->first() ?? 'Unknown';

        $user->delete();

        // Log to audit trail
        AuditLog::record('Deleted', 'users', $userId, "User '{$userName}' ({$roleName}) deleted");

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

}
