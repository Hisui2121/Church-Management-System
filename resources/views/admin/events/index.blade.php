<x-admin-layout>
    <x-slot:title>Events</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Events</h1>
                <p class="page-subtitle">Organize and manage church events</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Event
            </a>
        </div>

        @if ($events->count() > 0)
        <div class="events-grid">
            @foreach ($events as $event)
            <div class="event-card">
                <div class="event-header">
                    <h3 class="event-name">{{ $event->name }}</h3>
                    <div class="event-actions">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Delete" onclick="return confirm('Are you sure you want to delete this event?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                <p class="event-description">{{ $event->description ?? 'No description' }}</p>
                <div class="event-footer">
                    <small class="event-date">Created: {{ $event->created_at->format('M d, Y') }}</small>
                </div>
            </div>
            @endforeach
        </div>

        @if ($events->hasPages())
        <div class="pagination-wrapper">
            {{ $events->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-calendar-event-fill"></i></div>
            <div class="empty-state-title">No Events Yet</div>
            <div class="empty-state-text">Create your first event to engage and coordinate with church members</div>
            <button class="btn btn-primary">Create Event</button>
        </div>
        @endif
    </div>

    <style>
        .admin-page {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .event-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
        }

        .event-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .event-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            flex: 1;
        }

        .event-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: #ef4444;
        }

        .event-description {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0 0 16px 0;
            line-height: 1.5;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .event-date {
            font-size: 12px;
            color: var(--text-muted);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 64px;
            color: var(--primary-light);
            margin-bottom: 16px;
        }

        .empty-state-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state-text {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-admin-layout>
