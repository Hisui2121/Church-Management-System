<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('member_statuses')
            ->where('name', 'Active')
            ->update(['permissions' => json_encode([
                'view_dashboard',
                'view_members',
                'view_announcements',
            ])]);

        DB::table('member_statuses')
            ->where('name', 'Inactive')
            ->update(['permissions' => json_encode([
                'view_dashboard',
            ])]);

        DB::table('member_statuses')
            ->where('name', 'Visitor')
            ->update(['permissions' => json_encode([])]);

        $admin = User::updateOrCreate(
            ['email' => 'admin@church.com'],
            [
                'name'              => 'Church Admin',
                'password'          => Hash::make('Admn@1234'),
                'member_status_id'  => null,
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncRoles([$adminRole]);
    }
}