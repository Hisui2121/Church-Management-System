{{-- resources/views/audit_log/show.blade.php --}}

<x-layout>

<x-slot:title>
    Audit Log #{{ $auditLog->id }}
</x-slot:title>

<div class="container-fluid px-4">

    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="{{ route('audit_logs.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h2 class="fw-bold mb-0">
            <i class="bi bi-journal-text me-2"></i> Audit Log #{{ $auditLog->id }}
        </h2>
    </div>

    <div class="card shadow-sm" style="max-width: 640px;">
        <div class="card-body">

            <dl class="row mb-0">

                <dt class="col-sm-4 text-muted">User</dt>
                <dd class="col-sm-8">
                    {{ $auditLog->user?->name ?? 'System' }}
                </dd>

                <dt class="col-sm-4 text-muted">Action</dt>
                <dd class="col-sm-8">
                    @php
                        $badges = [
                            'created'    => 'success',
                            'updated'    => 'warning',
                            'deleted'    => 'danger',
                            'login'      => 'primary',
                            'logout'     => 'secondary',
                            'registered' => 'info',
                        ];
                        $color = $badges[$auditLog->action] ?? 'dark';
                    @endphp
                    <span class="badge bg-{{ $color }}">
                        {{ ucfirst($auditLog->action) }}
                    </span>
                </dd>

                <dt class="col-sm-4 text-muted">Table</dt>
                <dd class="col-sm-8">
                    <span class="badge bg-light text-dark border">
                        {{ $auditLog->table_name }}
                    </span>
                </dd>

                <dt class="col-sm-4 text-muted">Record ID</dt>
                <dd class="col-sm-8">{{ $auditLog->record_id ?? '—' }}</dd>

                <dt class="col-sm-4 text-muted">Description</dt>
                <dd class="col-sm-8">{{ $auditLog->description ?? '—' }}</dd>

                <dt class="col-sm-4 text-muted">Date & Time</dt>
                <dd class="col-sm-8">
                    {{ $auditLog->created_at->format('F d, Y — h:i:s A') }}
                </dd>

            </dl>

        </div>
    </div>

</div>
</x-layout>
