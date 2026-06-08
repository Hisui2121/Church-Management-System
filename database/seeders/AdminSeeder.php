<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@church.com'],
            [
                'name'              => 'Church Admin',
                'email'             => 'admin@church.com',
                'password'          => Hash::make('Admn@1234'),
                'role_id'           => 1,
                'member_status_id'  => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );
    }
}