{{-- resources/views/audit_log/index.blade.php --}}

<x-admin-layout>

<x-slot:title>
    Audit Trail
</x-slot:title>

<div class="audit-page">

    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-journal-text me-2"></i> Audit Trail
        </h1>
        <p class="page-subtitle">Track all system activities and changes</p>
    </div>

    {{-- Filters --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('audit_logs.index') }}" class="filter-form">

            <div class="filter-group">
                <input
                    type="text"
                    name="search"
                    class="filter-input"
                    placeholder="Search by description or user..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="filter-group">
                <select name="action" class="filter-select">
                    <option value="">All Actions</option>
                    @foreach ($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <select name="table_name" class="filter-select">
                    <option value="">All Tables</option>
                    @foreach ($tableNames as $table)
                        <option value="{{ $table }}" @selected(request('table_name') === $table)>
                            {{ $table }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('audit_logs.index') }}" class="btn btn-secondary">
                    Clear Filters
                </a>
                <form action="{{ route('audit_logs.clear') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')">
                        <i class="bi bi-trash"></i> Clear All Logs
                    </button>
                </form>
            </div>

        </form>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Table</th>
                    <th>Record ID</th>
                    <th>Description</th>
                    <th>Date & Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td class="text-muted small">{{ $log->id }}</td>

                        <td>
                            {{ $log->user?->name ?? 'System' }}
                        </td>

                        <td>
                            @php
                                $actionLabels = [
                                    'Created'    => 'Add',
                                    'Updated'    => 'Update',
                                    'Deleted'    => 'Delete',
                                    'login'      => 'Log In',
                                    'logout'     => 'Log Out',
                                    'registered' => 'Register',
                                    'viewed'     => 'View',
                                ];
                                $actionLabel = $actionLabels[$log->action] ?? ucfirst($log->action);
                                
                                $actionBadges = [
                                    'Created'    => 'success',
                                    'Updated'    => 'warning',
                                    'Deleted'    => 'danger',
                                    'login'      => 'primary',
                                    'logout'     => 'secondary',
                                    'registered' => 'info',
                                    'viewed'     => 'info',
                                ];
                                $color = $actionBadges[$log->action] ?? 'dark';
                            @endphp
                            <span class="badge badge-{{ $color }}">
                                {{ $actionLabel }}
                            </span>
                        </td>

                        <td>
                            <span class="badge badge-light">
                                {{ $log->table_name }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $log->record_id ?? '—' }}
                        </td>

                        <td class="small">
                            {{ Str::limit($log->description, 60) }}
                        </td>

                        <td class="small text-muted">
                            {{ $log->created_at->format('M d, Y h:i A') }}
                        </td>

                        <td>
                            <a href="{{ route('audit_logs.show', $log) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999; padding: 40px;">
                            No audit logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($logs->hasPages())
        <div class="pagination-wrapper">
            {{ $logs->links() }}
        </div>
    @endif

</div>

<style>
    .audit-page {
        padding: 0;
    }

    .page-header {
        display: flex;
        flex-direction: column;
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

    .filter-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group-actions {
        display: flex;
        gap: 12px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
    }

    .filter-select {
        cursor: pointer;
    }

    .table-wrapper {
        overflow-x: auto;
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    .table-dark {
        width: 100%;
        border-collapse: collapse;
    }

    .table-dark thead tr {
        background: #f3f4f6;
    }

    .table-dark thead th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-dark tbody tr {
        background: white;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s ease;
    }

    .table-dark tbody tr:hover {
        background: #f9fafb;
    }

    .table-dark tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #374151;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-light {
        background: #f3f4f6;
        color: #374151;
    }

    .badge-dark {
        background: #374151;
        color: white;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
        }

        .filter-group {
            min-width: auto;
        }

        .filter-group-actions {
            width: 100%;
        }

        .filter-group-actions .btn {
            flex: 1;
        }
    }
</style>

</x-admin-layout>

