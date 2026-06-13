<?php

namespace App\Observers;

use App\Models\Ministry;
use App\Models\AuditLog;

class MinistryObserver
{
    public function created(Ministry $ministry): void
    {
        AuditLog::record(
            'Created',
            'ministries',
            $ministry->id,
            "Ministry added: {$ministry->name}",
            'Ministries'
        );
    }

    public function updated(Ministry $ministry): void
    {
        AuditLog::record(
            'Updated',
            'ministries',
            $ministry->id,
            "Ministry updated: {$ministry->name}",
            'Ministries'
        );
    }

    public function deleted(Ministry $ministry): void
    {
        AuditLog::record(
            'Deleted',
            'ministries',
            $ministry->id,
            "Ministry deleted: {$ministry->name}",
            'Ministries'
        );
    }
}
