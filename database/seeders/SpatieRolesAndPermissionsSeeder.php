<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SpatieRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all permissions
        $permissions = [
            'view_dashboard',
            'view_members',
            'create_members',
            'edit_members',
            'delete_members',
            'view_ministries',
            'create_ministries',
            'edit_ministries',
            'delete_ministries',
            'view_events',
            'create_events',
            'edit_events',
            'delete_events',
            'view_announcements',
            'create_announcements',
            'edit_announcements',
            'delete_announcements',
            'view_audit_logs',
            'delete_audit_logs',
            'view_attendance',
            'create_attendance',
            'view_system_users',
            'create_system_users',
            'edit_system_users',
            'delete_system_users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions); // Admin gets everything, naks, jaedee manalang

        $pastor = Role::firstOrCreate(['name' => 'Pastor', 'guard_name' => 'web']);
        $pastor->syncPermissions([
            'view_dashboard',
            'view_members',
            'view_ministries',
            'view_events',
            'create_events',
            'edit_events',
            'view_announcements',
            'create_announcements',
            'edit_announcements',
            'view_attendance',
            'view_audit_logs',
        ]);

        $member = Role::firstOrCreate(['name' => 'Member', 'guard_name' => 'web']);
        $member->syncPermissions([
            'view_dashboard',
            'view_announcements',
            'view_events',
        ]);

        $guest = Role::firstOrCreate([
            'name' => 'Guest',
            'guard_name' => 'web'
        ]);
        
        $guest->syncPermissions([
            'view_announcements',
        ]);

        // Backfill roles for existing seeded users without overwriting any role already assigned.
        $adminUser = User::where('email', 'admin@church.com')->first();

        if ($adminUser && $adminUser->getRoleNames()->isEmpty()) {
            $adminUser->assignRole($admin);
        }

        // Admin account
        $adminUser = User::where('email', 'admin@church.com')->first(); 

        if ($adminUser) {
            $adminUser->syncRoles(['Admin']);
        }


        // Everyone else becomes member
        User::where('email', '!=', 'admin@church.com')
            ->get()
            ->each(function (User $user) use ($guest): void {
                if ($user->getRoleNames()->isEmpty()) {
                    $user->assignRole($guest);
                }
            });
    }
}

