<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::with('role', 'memberStatus')
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
        
        return view('admin.users.create', [
            'title' => 'Create User',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Automatically create member record if role is Member
        if ($user->role_id === Role::MEMBER) {
            // Split name into first and last name
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Get default member status (usually "Active")
            $defaultStatus = MemberStatus::where('name', 'Active')->first();

            // Create member record
            $member = Member::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $user->email,
                'member_status_id' => $defaultStatus?->id,
                'date_joined' => now(),
            ]);

            // Link member to user
            $user->update(['member_id' => $member->id]);
        }

        // Log to audit trail
        $roleName = $user->role->name ?? 'Unknown';
        AuditLog::record('Created', 'users', $user->id, "User '{$user->name}' ({$roleName}) created");

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'title' => 'User Details',
            'user' => $user->load('role', 'memberStatus', 'member'),
        ]);
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        
        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $oldRoleId = $user->role_id;
        $oldRoleName = $user->role->name ?? 'Unknown';
        $user->update($validated);
        $newRoleName = $user->role->name ?? 'Unknown';

        // Handle member creation if changing to Member role
        if ($oldRoleId !== Role::MEMBER && $user->role_id === Role::MEMBER && !$user->member_id) {
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            $defaultStatus = MemberStatus::where('name', 'Active')->first();

            $member = Member::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $user->email,
                'member_status_id' => $defaultStatus?->id,
                'date_joined' => now(),
            ]);

            $user->update(['member_id' => $member->id]);
        }

        // Log to audit trail
        AuditLog::record('Updated', 'users', $user->id, "User '{$user->name}' updated (role: {$oldRoleName} → {$newRoleName})");

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
        $userName = $user->name;
        $userId = $user->id;
        $roleName = $user->role->name ?? 'Unknown';

        // Prevent deleting currently logged-in user
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        // Log to audit trail
        AuditLog::record('Deleted', 'users', $userId, "User '{$userName}' ({$roleName}) deleted");

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
