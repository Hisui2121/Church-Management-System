{{-- resources/views/audit_log/index.blade.php --}}

<x-layout>

<x-slot:title>
    Audit Logs
</x-slot:title>

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-journal-text me-2"></i> Audit Trail
        </h2>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('audit_logs.index') }}" class="row g-3">

                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by description or user..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') === $action)>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="table_name" class="form-select">
                        <option value="">All Tables</option>
                        @foreach ($tableNames as $table)
                            <option value="{{ $table }}" @selected(request('table_name') === $table)>
                                {{ $table }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('audit_logs.index') }}" class="btn btn-outline-secondary w-100">
                        Clear
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
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
                                    {{ $log->user?->name ?? '<i class="text-muted">System</i>' }}
                                </td>

                                <td>
                                    @php
                                        $badges = [
                                            'created'    => 'success',
                                            'updated'    => 'warning',
                                            'deleted'    => 'danger',
                                            'login'      => 'primary',
                                            'logout'     => 'secondary',
                                            'registered' => 'info',
                                        ];
                                        $color = $badges[$log->action] ?? 'dark';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
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
                                    <a href="{{ route('audit_logs.show', $log) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No audit logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($logs->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }} entries
                </small>
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
</x-layout>
