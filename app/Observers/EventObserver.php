<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\AuditLog;

class EventObserver
{
    public function created(Event $event): void
    {
        AuditLog::record(
            'Created',
            'events',
            $event->id,
            "Event added: {$event->name}",
            'Events'
        );
    }

    public function updated(Event $event): void
    {
        AuditLog::record(
            'Updated',
            'events',
            $event->id,
            "Event updated: {$event->name}",
            'Events'
        );
    }

    public function deleted(Event $event): void
    {
        AuditLog::record(
            'Deleted',
            'events',
            $event->id,
            "Event deleted: {$event->name}",
            'Events'
        );
    }
}
