<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();

        $available = Permission::all()->mapWithKeys(function ($perm) {
            return [$perm->name => ucwords(str_replace('_', ' ', $perm->name))];
        })->toArray();

        return view('admin.member-statuses.index', compact('roles', 'available'));
    }

    public function edit(Role $role)
    {
        $available = Permission::all()->pluck('name', 'name')->toArray();

        $actionLabels = [
            'view'      => 'View',
            'create'    => 'Create',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
        ];

        $grouped = [];

        foreach ($available as $name) {
            // Splits (ex: create_members -> action=create, page=members)
            $parts = explode('_', $name, 2);

            if (count($parts) === 2 && isset($actionLabels[$parts[0]])) {
                $action = $parts[0];
                $page   = $parts[1];
            } else {
                $action = 'view';
                $page   = $name;
            }

            $pageLabel = ucwords(str_replace('_', ' ', $page));

            $grouped[$pageLabel]['page'] = $pageLabel;
            $grouped[$pageLabel]['permissions'][$name] = $actionLabels[$action] ?? ucwords(str_replace('_', ' ', $action));
        }

        // Order of actions, to be consistent with each group
        $order = ['view', 'create', 'edit', 'delete'];
        foreach ($grouped as &$group) {
            uksort($group['permissions'], function ($a, $b) use ($order) {
                $aAction = explode('_', $a, 2)[0];
                $bAction = explode('_', $b, 2)[0];
                $aPos    = array_search($aAction, $order);
                $bPos    = array_search($bAction, $order);
                $aPos    = $aPos === false ? 99 : $aPos;
                $bPos    = $bPos === false ? 99 : $bPos;
                return $aPos <=> $bPos;
            });
        }
        unset($group);

        ksort($grouped);

        return view('admin.member-statuses.edit', compact('role', 'grouped'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions'   => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $permissions = $validated['permissions'] ?? [];

        $role->syncPermissions($permissions);

        AuditLog::record('Updated', 'roles', $role->id, "Permissions updated for role '{$role->name}': " . implode(', ', $permissions));

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Permissions for \"{$role->name}\" updated.");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        $role = Role::create([
            'name'       => $validated['name'],
            'guard_name' => 'web',
        ]);

        AuditLog::record('Created', 'roles', $role->id, "Created new role '{$role->name}'");

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Role \"{$role->name}\" created.");
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Admin', 'Pastor', 'Member'])) {
            return redirect()
                ->route('admin.permissions.index')
                ->with('error', "The \"{$role->name}\" role is a system role and cannot be deleted.");
        }

        if ($role->users()->count() > 0) {
            return redirect()
                ->route('admin.permissions.index')
                ->with('error', "Cannot delete \"{$role->name}\" — it is still assigned to one or more users.");
        }

        $roleName = $role->name;
        $role->delete();

        AuditLog::record('Deleted', 'roles', null, "Deleted role '{$roleName}'");

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "Role \"{$roleName}\" deleted.");
    }
}
