<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\MemberStatus;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'memberStatus')
            ->orderBy('name')
            ->get();
        $available = MemberStatus::availablePermissions();

        return view('admin.member-statuses.index', compact('users', 'available'));
    }

    public function edit(User $user)
    {
        $available = MemberStatus::availablePermissions();

        return view('admin.member-statuses.edit', compact('user', 'available'));
    }

    public function update(Request $request, User $user)
    {
        $permissions = array_values(array_intersect(
            $request->input('permissions', []),
            array_keys(MemberStatus::availablePermissions())
        ));

        $user->update([
            'permissions' => $permissions,
        ]);

        AuditLog::record('Updated', 'users', $user->id, "Permissions updated for user '{$user->name}'");

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permissions for \"{$user->name}\" updated.");
    }
}
