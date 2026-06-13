<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AuditLog;

class UserObserver
{
    public function created(User $user): void
    {
        AuditLog::record(
            'Created',
            'users',
            $user->id,
            "Member added: {$user->name}",
            'Members'
        );
    }

    public function updated(User $user): void
    {
        AuditLog::record(
            'Updated',
            'users',
            $user->id,
            "Member updated: {$user->name}",
            'Members'
        );
    }

    public function deleted(User $user): void
    {
        AuditLog::record(
            'Deleted',
            'users',
            $user->id,
            "Member deleted: {$user->name}",
            'Members'
        );
    }
}
