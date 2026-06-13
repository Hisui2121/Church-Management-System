@props(['announcements', 'events'])

<section class="main-section">
    {{-- ANNOUNCEMENTS --}}
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><i class="bi bi-megaphone-fill"></i> Announcements</h3>
            <a href="{{ route('announcements.index') }}" class="view-all-link">View All</a>
        </div>
        <div class="announcements-grid">
            @forelse ($announcements as $announcement)
            <div class="announcement-card">
                @if ($announcement->image_path)
                <div class="announcement-image">
                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}">
                </div>
                @endif
                @unless ($announcement->image_path)
                <div class="announcement-content">
                    <h4 class="announcement-title">{{ $announcement->title }}</h4>
                    <p class="announcement-date"><i class="bi bi-calendar3"></i> {{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}</p>
                    <p class="announcement-excerpt">{{ Str::limit(strip_tags($announcement->body), 100) }}</p>
                </div>
                @endunless
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-megaphone-fill"></i>
                <p>No announcements yet</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- EVENTS --}}
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><i class="bi bi-calendar-event-fill"></i> Upcoming Events</h3>
            <a href="{{ route('events.index') }}" class="view-all-link">View All</a>
        </div>
        <div class="events-list">
            @forelse ($events as $event)
            <div class="event-item">
                @if ($event->image_path)
                <div class="event-image"><img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"></div>
                @else
                <div class="event-image-placeholder"><i class="bi bi-calendar-event"></i></div>
                @endif
                <div class="event-details">
                    <h4 class="event-title">{{ $event->name }}</h4>
                    @if ($event->event_date)
                    <p class="event-date">
                        <i class="bi bi-calendar3"></i> {{ $event->event_date->format('M d, Y') }}
                        @if ($event->event_time) <span class="event-time"><i class="bi bi-clock"></i> {{ $event->event_time }}</span> @endif
                    </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state"><i class="bi bi-calendar-event-fill"></i><p>No upcoming events</p></div>
            @endforelse
        </div>
    </div>
</section>