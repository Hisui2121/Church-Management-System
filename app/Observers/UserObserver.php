<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AuditLog;

class UserObserver
{
    public function created(User $user): void
    {
        AuditLog::record(
            'created',
            'users',
            $user->id,
            "Member added: {$user->name}"
        );
    }

    public function updated(User $user): void
    {
        AuditLog::record(
            'updated',
            'users',
            $user->id,
            "Member updated: {$user->name}"
        );
    }

    public function deleted(User $user): void
    {
        AuditLog::record(
            'deleted',
            'users',
            $user->id,
            "Member deleted: {$user->name}"
        );
    }
}
