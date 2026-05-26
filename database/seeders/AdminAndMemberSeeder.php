<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class AdminAndMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         ADMIN ACCOUNT
        */
        User::create([
            'name' => 'Church Administrator',
            'email' => 'admin@churchms.com',
            'password' => Hash::make('password123'),
        ]);

        /*
         SAMPLE MEMBERS
        */

        $members = [

            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'contact_number' => '09171234567',
                'gender' => 'Male',
                'birthdate' => '1998-05-10',
                'address' => 'Naic, Cavite',
                'member_type' => 'Regular',
                'member_status' => 'Active',
                'date_joined' => now(),
            ],

            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria@example.com',
                'contact_number' => '09181234567',
                'gender' => 'Female',
                'birthdate' => '1996-08-21',
                'address' => 'Tanza, Cavite',
                'member_type' => 'Volunteer',
                'member_status' => 'Active',
                'date_joined' => now(),
            ],

            [
                'first_name' => 'Joshua',
                'last_name' => 'Reyes',
                'email' => 'joshua@example.com',
                'contact_number' => '09221234567',
                'gender' => 'Male',
                'birthdate' => '2000-11-15',
                'address' => 'Trece Martires, Cavite',
                'member_type' => 'Youth',
                'member_status' => 'Inactive',
                'date_joined' => now(),
            ],

            [
                'first_name' => 'Angela',
                'last_name' => 'Cruz',
                'email' => 'angela@example.com',
                'contact_number' => '09351234567',
                'gender' => 'Female',
                'birthdate' => '1994-03-08',
                'address' => 'Dasmariñas, Cavite',
                'member_type' => 'Regular',
                'member_status' => 'Visitor',
                'date_joined' => now(),
            ],

            [
                'first_name' => 'David',
                'last_name' => 'Garcia',
                'email' => 'david@example.com',
                'contact_number' => '09471234567',
                'gender' => 'Male',
                'birthdate' => '1992-01-19',
                'address' => 'Imus, Cavite',
                'member_type' => 'Volunteer',
                'member_status' => 'Active',
                'date_joined' => now(),
            ],

        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}