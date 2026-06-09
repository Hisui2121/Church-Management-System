<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\AuditLog;

class EventObserver
{
    public function created(Event $event): void
    {
        AuditLog::record(
            'created',
            'events',
            $event->id,
            "Event added: {$event->name}"
        );
    }

    public function updated(Event $event): void
    {
        AuditLog::record(
            'updated',
            'events',
            $event->id,
            "Event updated: {$event->name}"
        );
    }

    public function deleted(Event $event): void
    {
        AuditLog::record(
            'deleted',
            'events',
            $event->id,
            "Event deleted: {$event->name}"
        );
    }
}
