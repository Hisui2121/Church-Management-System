<x-admin-layout>
    <x-slot:title>Service Sessions</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Service Sessions</h1>
                <p class="page-subtitle">Manage all service sessions and attendance records</p>
            </div>
            <a href="{{ route('admin.attendance.sessions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Session
            </a>
        </div>

        @if ($sessions->count() > 0)
        <div class="sessions-list">
            @foreach ($sessions as $session)
            <div class="session-card">
                <div class="session-header">
                    <div class="session-info">
                        <div class="session-date-badge">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $session->session_date ? $session->session_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <h3 class="session-title">{{ $session->service_title ?? 'Untitled Service' }}</h3>
                            <div class="session-meta">
                                @if($session->pastor)
                                    <span class="meta-item">
                                        <i class="bi bi-person-fill"></i>
                                        {{ $session->pastor->name }}
                                    </span>
                                @endif
                                @if($session->verse)
                                    <span class="meta-item">
                                        <i class="bi bi-book-fill"></i>
                                        {{ $session->verse }}
                                    </span>
                                @endif
                                <span class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    Started: {{ $session->started_at->format('M d, Y h:i A') }}
                                </span>
                                @if($session->ended_at)
                                    <span class="meta-item">
                                        <i class="bi bi-stop-circle"></i>
                                        Ended: {{ $session->ended_at->format('h:i A') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="session-actions">
                        <span class="status-badge {{ $session->is_active ? 'active' : 'inactive' }}">
                            {{ $session->is_active ? 'Active' : 'Completed' }}
                        </span>
                        <a href="{{ route('admin.attendance.sessions.edit', $session->id) }}" class="action-btn" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.attendance.sessions.destroy', $session->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Delete" onclick="return confirm('Are you sure?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if($session->attendances_count ?? false || $session->attendances)
                    <div class="session-footer">
                        <small class="attendance-count">
                            <i class="bi bi-check-circle"></i>
                            {{ count($session->attendances ?? []) }} attendees checked in
                        </small>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        @if ($sessions->hasPages())
        <div class="pagination-wrapper">
            {{ $sessions->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="empty-state-title">No Service Sessions</div>
            <div class="empty-state-text">Create your first service session to start tracking attendance</div>
            <a href="{{ route('admin.attendance.sessions.create') }}" class="btn btn-primary">Create Session</a>
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

        .sessions-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 30px;
        }

        .session-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .session-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .session-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 12px;
        }

        .session-info {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex: 1;
        }

        .session-date-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-light);
            color: var(--primary);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .session-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .session-meta {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .session-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-badge.inactive {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
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

        .session-footer {
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .attendance-count {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
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

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
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

            .session-header {
                flex-direction: column;
            }

            .session-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .session-info {
                flex-direction: column;
            }
        }
    </style>
</x-admin-layout>
