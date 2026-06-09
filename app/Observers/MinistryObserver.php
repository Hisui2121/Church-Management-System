<?php

namespace App\Observers;

use App\Models\Ministry;
use App\Models\AuditLog;

class MinistryObserver
{
    public function created(Ministry $ministry): void
    {
        AuditLog::record(
            'created',
            'ministries',
            $ministry->id,
            "Ministry added: {$ministry->name}"
        );
    }

    public function updated(Ministry $ministry): void
    {
        AuditLog::record(
            'updated',
            'ministries',
            $ministry->id,
            "Ministry updated: {$ministry->name}"
        );
    }

    public function deleted(Ministry $ministry): void
    {
        AuditLog::record(
            'deleted',
            'ministries',
            $ministry->id,
            "Ministry deleted: {$ministry->name}"
        );
    }
}
