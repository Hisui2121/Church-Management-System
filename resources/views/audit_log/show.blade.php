{{-- resources/views/audit_log/show.blade.php --}}

<x-admin-layout>

<x-slot:title>
    Audit Log #{{ $auditLog->id }}
</x-slot:title>

<div class="audit-log-show">

    <div class="page-header">
        <a href="{{ route('audit_logs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h1 class="page-title">
            <i class="bi bi-journal-text me-2"></i> Audit Log #{{ $auditLog->id }}
        </h1>
    </div>

    <div class="details-card">
        <div class="details-list">

            <div class="detail-row">
                <dt class="detail-label">User</dt>
                <dd class="detail-value">
                    {{ $auditLog->user?->name ?? 'System' }}
                </dd>
            </div>

            <div class="detail-row">
                <dt class="detail-label">Action</dt>
                <dd class="detail-value">
                    @php
                        $actionLabels = [
                            'created'    => 'Add',
                            'updated'    => 'Update',
                            'deleted'    => 'Delete',
                            'login'      => 'Log In',
                            'logout'     => 'Log Out',
                            'registered' => 'Register',
                            'viewed'     => 'View',
                        ];
                        $actionLabel = $actionLabels[$auditLog->action] ?? ucfirst($auditLog->action);
                        
                        $actionBadges = [
                            'created'    => 'success',
                            'updated'    => 'warning',
                            'deleted'    => 'danger',
                            'login'      => 'primary',
                            'logout'     => 'secondary',
                            'registered' => 'info',
                            'viewed'     => 'info',
                        ];
                        $color = $actionBadges[$auditLog->action] ?? 'dark';
                    @endphp
                    <span class="badge badge-{{ $color }}">
                        {{ $actionLabel }}
                    </span>
                </dd>
            </div>

            <div class="detail-row">
                <dt class="detail-label">Table</dt>
                <dd class="detail-value">
                    <span class="badge badge-light">
                        {{ $auditLog->table_name }}
                    </span>
                </dd>
            </div>

            <div class="detail-row">
                <dt class="detail-label">Record ID</dt>
                <dd class="detail-value">{{ $auditLog->record_id ?? '—' }}</dd>
            </div>

            <div class="detail-row">
                <dt class="detail-label">Description</dt>
                <dd class="detail-value">{{ $auditLog->description ?? '—' }}</dd>
            </div>

            <div class="detail-row">
                <dt class="detail-label">Date & Time</dt>
                <dd class="detail-value">
                    {{ $auditLog->created_at->format('F d, Y — h:i:s A') }}
                </dd>
            </div>

        </div>
    </div>

</div>

<style>
    .audit-log-show {
        padding: 0;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-secondary {
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: #f9fafb;
    }

    .details-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        max-width: 640px;
    }

    .details-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }

    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        font-size: 14px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 14px;
        color: var(--text-dark);
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
</style>

</x-admin-layout>
