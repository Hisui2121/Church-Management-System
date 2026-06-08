<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChurchManagementSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------------------------------
        // Lookup tables
        // ------------------------------------------------------------
        DB::table('roles')->insert([
            ['name' => 'Admin',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pastor',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Member',  'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('member_statuses')->insert([
            ['name' => 'Active',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Inactive', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Visitor',  'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('member_types')->insert([
            ['name' => 'Regular', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Youth',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior',  'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('ministries')->insert([
            ['name' => 'Worship Ministry',  'description' => 'Leads the congregation in praise and worship',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Youth Ministry',    'description' => 'Dedicated to discipling and guiding the youth', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Outreach Ministry', 'description' => 'Community service and evangelism programs',      'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Media Ministry',    'description' => 'Handles audio, visual, and social media',        'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('services')->insert([
            ['name' => 'Sunday Worship Service',     'description' => 'Main weekly worship service every Sunday', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wednesday Prayer Meeting',   'description' => 'Midweek prayer and Bible study',           'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // BAPTISMS (no member_id FK yet — circular dependency)
        // ------------------------------------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('baptisms')->insert([
            ['id' => 1, 'member_id' => null, 'status' => 'Baptized', 'date' => '2018-04-15', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'member_id' => null, 'status' => 'Baptized', 'date' => '2019-06-09', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'member_id' => null, 'status' => 'Baptized', 'date' => '2020-03-22', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'member_id' => null, 'status' => 'Pending',  'date' => '2024-12-01', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('family_groups')->insert([
            ['id' => 1, 'family_name' => 'Paredes Family',  'head_of_family' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'family_name' => 'Casano Family',   'head_of_family' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'family_name' => 'Ayapana Family',  'head_of_family' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'family_name' => 'Manalang Family', 'head_of_family' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // MEMBERS
        // ------------------------------------------------------------
        DB::table('members')->insert([
            [
                'id'               => 1,
                'first_name'       => 'Ritz Gabriel',
                'last_name'        => 'Paredes',
                'birthdate'        => '2001-03-10',
                'contact_number'   => '09171234567',
                'email'            => 'ritz.paredes@email.com',
                'address'          => 'San Juan, Ilocos Sur',
                'profile_photo'    => null,
                'member_status_id' => 1,
                'date_joined'      => '2018-04-15 08:00:00',
                'member_type_id'   => 1,
                'baptism_id'       => 1,
                'gender'           => 'M',
                'family_group_id'  => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => 2,
                'first_name'       => 'Jade Stephen',
                'last_name'        => 'Casano',
                'birthdate'        => '2000-07-22',
                'contact_number'   => '09281234568',
                'email'            => 'jade.casano@email.com',
                'address'          => 'Vigan City, Ilocos Sur',
                'profile_photo'    => null,
                'member_status_id' => 1,
                'date_joined'      => '2019-06-09 08:00:00',
                'member_type_id'   => 1,
                'baptism_id'       => 2,
                'gender'           => 'M',
                'family_group_id'  => 2,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => 3,
                'first_name'       => 'Jobert Bryze',
                'last_name'        => 'Ayapana',
                'birthdate'        => '1999-11-05',
                'contact_number'   => '09391234569',
                'email'            => 'jobert.ayapana@email.com',
                'address'          => 'Candon City, Ilocos Sur',
                'profile_photo'    => null,
                'member_status_id' => 1,
                'date_joined'      => '2020-03-22 08:00:00',
                'member_type_id'   => 1,
                'baptism_id'       => 3,
                'gender'           => 'M',
                'family_group_id'  => 3,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => 4,
                'first_name'       => 'Jaedee Janiell',
                'last_name'        => 'Manalang',
                'birthdate'        => '2003-01-18',
                'contact_number'   => '09501234570',
                'email'            => 'jaedee.manalang@email.com',
                'address'          => 'Narvacan, Ilocos Sur',
                'profile_photo'    => null,
                'member_status_id' => 1,
                'date_joined'      => '2024-12-01 08:00:00',
                'member_type_id'   => 2,
                'baptism_id'       => 4,
                'gender'           => 'F',
                'family_group_id'  => 4,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);

        // Resolve circular FKs now that members exist
        DB::table('baptisms')->where('id', 1)->update(['member_id' => 1]);
        DB::table('baptisms')->where('id', 2)->update(['member_id' => 2]);
        DB::table('baptisms')->where('id', 3)->update(['member_id' => 3]);
        DB::table('baptisms')->where('id', 4)->update(['member_id' => 4]);

        DB::table('family_groups')->where('id', 1)->update(['head_of_family' => 1]);
        DB::table('family_groups')->where('id', 2)->update(['head_of_family' => 2]);
        DB::table('family_groups')->where('id', 3)->update(['head_of_family' => 3]);
        DB::table('family_groups')->where('id', 4)->update(['head_of_family' => 4]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ------------------------------------------------------------
        // USERS
        // ------------------------------------------------------------
        DB::table('users')->insert([
            ['name' => 'Ritz Gabriell Paredes',   'email' => 'ritz.paredes@email.com',   'password' => bcrypt('password'), 'member_id' => 1, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jade Stephen Casano',     'email' => 'jade.casano@email.com',    'password' => bcrypt('password'), 'member_id' => 2, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jobert Bryze Ayapana',    'email' => 'jobert.ayapana@email.com', 'password' => bcrypt('password'), 'member_id' => 3, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jaedee Janiell Manalang', 'email' => 'jaedee.manalang@email.com','password' => bcrypt('password'), 'member_id' => 4, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // MEMBER_MINISTRIES
        // ------------------------------------------------------------
        DB::table('member_ministries')->insert([
            ['member_id' => 1, 'ministry_id' => 4, 'joined_at' => '2018-05-01', 'role' => 'Media Operator', 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 2, 'ministry_id' => 1, 'joined_at' => '2019-07-01', 'role' => 'Vocalist',       'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 3, 'ministry_id' => 3, 'joined_at' => '2020-04-01', 'role' => 'Volunteer',      'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 4, 'ministry_id' => 2, 'joined_at' => '2024-12-15', 'role' => 'Youth Member',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // MEMBER_INTERESTS
        // ------------------------------------------------------------
        DB::table('member_interests')->insert([
            ['member_id' => 1, 'ministry_id' => 1, 'expressed_at' => '2023-01-10', 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 2, 'ministry_id' => 2, 'expressed_at' => '2023-03-15', 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 3, 'ministry_id' => 2, 'expressed_at' => '2023-06-20', 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 4, 'ministry_id' => 3, 'expressed_at' => '2024-12-20', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // ATTENDANCE
        // ------------------------------------------------------------
        DB::table('attendances')->insert([
            ['member_id' => 1, 'date' => '2026-05-18', 'service_id' => 1, 'is_present' => true,  'recorded_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 2, 'date' => '2026-05-18', 'service_id' => 1, 'is_present' => true,  'recorded_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 3, 'date' => '2026-05-18', 'service_id' => 1, 'is_present' => false, 'recorded_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['member_id' => 4, 'date' => '2026-05-18', 'service_id' => 1, 'is_present' => true,  'recorded_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ------------------------------------------------------------
        // ANNOUNCEMENTS
        // ------------------------------------------------------------
        DB::table('announcements')->insert([
            [
                'title'        => 'Welcome New Members!',
                'body'         => 'We warmly welcome Ritz, Jade, Jobert, and Jaedee to our church family. May God bless your journey with us!',
                'created_by'   => 1,
                'is_active'    => true,
                'published_at' => '2026-05-18 09:00:00',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
