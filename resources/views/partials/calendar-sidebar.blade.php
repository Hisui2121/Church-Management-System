@props(['eventsThisWeek'])

<aside class="sidebar-section">
    <div class="section-card calendar-card">
        <div class="calendar-header">
            <h3 class="calendar-title"><i class="bi bi-calendar-fill"></i> Church Calendar</h3>
            <div class="calendar-nav">
                <button id="calendarPrev" class="calendar-btn" title="Previous Month"><i class="bi bi-chevron-left"></i></button>
                <span id="calendarMonth" class="calendar-month"></span>
                <button id="calendarNext" class="calendar-btn" title="Next Month"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
        <div id="calendar" class="calendar"></div>
    </div>

    <div class="section-card">
        <h4 class="section-subtitle">Upcoming This Week</h4>
        <div class="upcoming-events">
            @forelse ($eventsThisWeek as $event)
            <div class="upcoming-event-item">
                <span class="event-indicator"></span>
                <div>
                    <p class="event-name">{{ $event->name }}</p>
                    <p class="event-small-date">{{ $event->event_date?->format('M d') }}</p>
                </div>
            </div>
            @empty
            <p class="no-events-text">No events this week</p>
            @endforelse
        </div>
    </div>
</aside>