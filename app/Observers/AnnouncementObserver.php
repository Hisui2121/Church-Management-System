<?php

namespace App\Observers;

use App\Models\Announcement;
use App\Models\AuditLog;

class AnnouncementObserver
{
    public function created(Announcement $announcement): void
    {
        AuditLog::record(
            'Created',
            'announcements',
            $announcement->id,
            "Announcement added: {$announcement->title}",
            'Announcements'
        );
    }

    public function updated(Announcement $announcement): void
    {
        AuditLog::record(
            'Updated',
            'announcements',
            $announcement->id,
            "Announcement updated: {$announcement->title}",
            'Announcements'
        );
    }

    public function deleted(Announcement $announcement): void
    {
        AuditLog::record(
            'Deleted',
            'announcements',
            $announcement->id,
            "Announcement deleted: {$announcement->title}",
            'Announcements'
        );
    }
}
