<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStatus extends Model
{
    protected $fillable = ['name', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public static function availablePermissions(): array
    {
        return [
            'view_dashboard'        => 'View Dashboard',
            'view_members'          => 'View Members',
            'create_members'        => 'Create Members',
            'edit_members'          => 'Edit Members',
            'delete_members'        => 'Delete Members',
            'view_ministries'       => 'View Ministries',
            'view_events'           => 'View Events',
            'view_announcements'    => 'View Announcements',
            'view_audit_logs'       => 'View Audit Logs',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}