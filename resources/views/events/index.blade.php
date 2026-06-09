<x-member-layout>
    <x-slot:title>Events</x-slot:title>

    <div class="events-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Events</h1>
                <p class="page-subtitle">Discover upcoming church events</p>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="events-container">
            @forelse ($events as $event)
            <div class="event-card">
                @if ($event->image_path)
                <div class="event-image">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}">
                </div>
                @else
                <div class="event-image-placeholder">
                    <i class="bi bi-calendar-event"></i>
                </div>
                @endif

                <div class="event-details">
                    <h3 class="event-title">{{ $event->name }}</h3>
                    
                    @if ($event->event_date)
                    <div class="event-date-time">
                        <span class="event-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $event->event_date->format('M d, Y') }}
                        </span>
                        @if ($event->event_time)
                        <span class="event-time">
                            <i class="bi bi-clock"></i>
                            {{ $event->event_time }}
                        </span>
                        @endif
                    </div>
                    @endif

                    @if ($event->description)
                    <p class="event-description">{{ Str::limit($event->description, 200) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-calendar-event"></i>
                <h3>No Events</h3>
                <p>There are currently no upcoming events.</p>
            </div>
            @endforelse
        </div>

        @if ($events->hasPages())
        <div class="pagination-wrapper">
            {{ $events->links() }}
        </div>
        @endif
    </div>

    <style>
        .events-page {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 16px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .page-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .events-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 24px;
        }

        .event-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            display: flex;
            gap: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .event-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .event-image {
            width: 220px;
            height: 200px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-image-placeholder {
            width: 220px;
            height: 200px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .event-details {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .event-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 12px 0;
        }

        .event-date-time {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .event-date,
        .event-time {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .event-description {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .event-card {
                flex-direction: column;
            }

            .event-image,
            .event-image-placeholder {
                width: 100%;
                height: 250px;
            }

            .page-header {
                flex-direction: column;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .event-date-time {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</x-member-layout>
