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
            'view_events',
            'view_announcements',
            'view_audit_logs',
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
            'view_announcements',
        ]);

        $member = Role::firstOrCreate(['name' => 'Member', 'guard_name' => 'web']);
        $member->syncPermissions([
            'view_dashboard',
            'view_announcements',
            'view_events',
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
            ->each(function (User $user) use ($member): void {
                    $user->syncRoles($member);
            });
    }
}

