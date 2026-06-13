<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserPermissionsRequest;
use App\Models\AuditLog;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions', 'memberStatus')
            ->orderBy('name')
            ->get();

        $available = Permission::all()->mapWithKeys(function ($perm) {
        return [$perm->name => ucwords(str_replace('_', ' ', $perm->name))];
    })->toArray();

        return view('admin.member-statuses.index', compact('users', 'available'));
    }

    public function edit(User $user)
    {
        $available = Permission::all()->pluck('name', 'name')->toArray();

        $available = collect($available)->mapWithKeys(function ($name) {
            $label = ucwords(str_replace('_', ' ', $name));
            return [$name => $label];
        })->toArray();
        return view('admin.member-statuses.edit', compact('user', 'available'));
    }

    public function update(UpdateUserPermissionsRequest $request, User $user)
    {
        $permissions = $request->validated('permissions', []);

        $user->syncPermissions($permissions);

        AuditLog::record('Updated', 'users', $user->id, "Permissions updated for user '{$user->name}': " . implode(', ', $permissions));

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permissions for \"{$user->name}\" updated.");
    }
}
