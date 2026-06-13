{{-- resources/views/audit_log/index.blade.php --}}

@php $layout = auth()->user()->isAdmin() ? 'admin-layout' : 'member-layout'; @endphp
<x-dynamic-component :component="$layout">

<x-slot:title>
    Audit Trail
</x-slot:title>

<div class="audit-page">

    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="bi bi-journal-text me-2"></i> Audit Trail
            </h1>
            <p class="page-subtitle">Track all system activities and changes</p>
        </div>
        <form action="{{ route('audit_logs.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')">
                <i class="bi bi-trash"></i> Clear All Logs
            </button>
        </form>
    </div>

    {{-- Filters --}}
    <div class="filter-card">
        @php
            $selectedActions = $filters['action'] ?? [];
            $selectedTables = $filters['table_name'] ?? [];
        @endphp

        <form method="GET" action="{{ route('audit_logs.index') }}" class="filter-form" id="auditFilterForm">

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
                <details class="checkbox-dropdown">
                    <summary>
                        <span>{{ count($selectedActions) ? count($selectedActions) . ' Actions' : 'All Actions' }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </summary>
                    <div class="checkbox-menu">
                        @foreach ($actions as $action)
                            <label class="checkbox-option">
                                <input type="checkbox" name="action[]" value="{{ $action }}" @checked(in_array($action, $selectedActions, true))>
                                <span>{{ ucfirst($action) }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>
            </div>

            <div class="filter-group">
                <details class="checkbox-dropdown">
                    <summary>
                        <span>{{ count($selectedTables) ? count($selectedTables) . ' Tables' : 'All Tables' }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </summary>
                    <div class="checkbox-menu">
                        @foreach ($tableNames as $table)
                            <label class="checkbox-option">
                                <input type="checkbox" name="table_name[]" value="{{ $table }}" @checked(in_array($table, $selectedTables, true))>
                                <span>{{ $table }}</span>
                            </label>
                        @endforeach
                    </div>
                </details>
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
                                    'Added'      => 'Add',
                                    'Created'    => 'Create',
                                    'created'    => 'Create',
                                    'Updated'    => 'Update',
                                    'updated'    => 'Update',
                                    'Deleted'    => 'Delete',
                                    'deleted'    => 'Delete',
                                    'added'      => 'Add',
                                    'login'      => 'Log In',
                                    'logout'     => 'Log Out',
                                    'registered' => 'Register',
                                    'viewed'     => 'View',
                                ];
                                $actionLabel = $actionLabels[$log->action] ?? ucfirst($log->action);
                                
                                $actionBadges = [
                                    'Added'      => 'success',
                                    'Created'    => 'success',
                                    'created'    => 'success',
                                    'Updated'    => 'warning',
                                    'updated'    => 'warning',
                                    'Deleted'    => 'danger',
                                    'deleted'    => 'danger',
                                    'added'      => 'success',
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
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
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

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
    }

    .checkbox-dropdown {
        position: relative;
        width: 100%;
    }

    .checkbox-dropdown summary {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        background: white;
        color: var(--text-dark);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        list-style: none;
    }

    .checkbox-dropdown summary::-webkit-details-marker {
        display: none;
    }

    .checkbox-dropdown[open] summary {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .checkbox-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        z-index: 20;
        max-height: 240px;
        overflow-y: auto;
        padding: 8px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
    }

    .checkbox-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 8px;
        border-radius: 6px;
        color: var(--text-dark);
        font-size: 14px;
        cursor: pointer;
    }

    .checkbox-option:hover {
        background: var(--bg-light);
    }

    .checkbox-option input {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
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
        .page-header {
            flex-direction: column;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-group {
            min-width: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('auditFilterForm');
        if (!form) {
            return;
        }

        form.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                form.submit();
            });
        });

        document.addEventListener('click', function (event) {
            document.querySelectorAll('.checkbox-dropdown[open]').forEach(function (dropdown) {
                if (!dropdown.contains(event.target)) {
                    dropdown.removeAttribute('open');
                }
            });
        });
    });
</script>

</x-dynamic-component>
