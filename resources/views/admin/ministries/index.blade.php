@php $layout = auth()->user()->isAdmin() ? 'admin-layout' : 'member-layout'; @endphp
<x-dynamic-component :component="$layout">
    <x-slot:title>Ministries</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Ministries</h1>
                <p class="page-subtitle">Manage church ministries and departments</p>
            </div>
            <a href="{{ route('admin.ministries.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Ministry
            </a>
        </div>

        @if ($ministries->count() > 0)
        <div class="ministries-grid">
            @foreach ($ministries as $ministry)
            <div class="ministry-card">
                <div class="ministry-header">
                    <h3 class="ministry-name">{{ $ministry->name }}</h3>
                    <div class="ministry-actions">
                        <a href="{{ route('admin.ministries.edit', $ministry->id) }}" class="action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.ministries.destroy', $ministry->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Delete" onclick="return confirm('Are you sure you want to delete this ministry?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                <p class="ministry-description">{{ $ministry->description ?? 'No description' }}</p>
                <div class="ministry-footer">
                    <small class="ministry-date">Created: {{ $ministry->created_at->format('M d, Y') }}</small>
                </div>
            </div>
            @endforeach
        </div>

        @if ($ministries->hasPages())
        <div class="pagination-wrapper">
            {{ $ministries->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-heart-fill"></i></div>
            <div class="empty-state-title">No Ministries Yet</div>
            <div class="empty-state-text">Start by creating your first ministry to organize your church activities</div>
            <button class="btn btn-primary">Create Ministry</button>
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

        .ministries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .ministry-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
        }

        .ministry-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .ministry-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .ministry-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            flex: 1;
        }

        .ministry-actions {
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

        .ministry-description {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0 0 16px 0;
            line-height: 1.5;
        }

        .ministry-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .ministry-date {
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

            .ministries-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-dynamic-component>
