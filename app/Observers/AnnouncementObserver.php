<?php

namespace App\Observers;

use App\Models\Announcement;
use App\Models\AuditLog;

class AnnouncementObserver
{
    public function created(Announcement $announcement): void
    {
        AuditLog::record(
            'created',
            'announcements',
            $announcement->id,
            "Announcement added: {$announcement->title}"
        );
    }

    public function updated(Announcement $announcement): void
    {
        AuditLog::record(
            'updated',
            'announcements',
            $announcement->id,
            "Announcement updated: {$announcement->title}"
        );
    }

    public function deleted(Announcement $announcement): void
    {
        AuditLog::record(
            'deleted',
            'announcements',
            $announcement->id,
            "Announcement deleted: {$announcement->title}"
        );
    }
}
