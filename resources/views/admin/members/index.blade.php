<x-admin-layout>
    <x-slot:title>Members</x-slot:title>

    <div class="admin-members-page">
        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Members</h1>
                <p class="page-subtitle">Manage and view all church members</p>
            </div>
            <div class="header-actions-right">
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Member
                </a>
            </div>
        </div>

        {{-- FILTERS & SEARCH --}}
        <form method="GET" action="{{ route('admin.members.index') }}" class="filter-bar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search members..." class="filter-input">
            </div>
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <select name="role" class="filter-select" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected(($filters['role'] ?? '') === $role)>{{ $role }}</option>
                @endforeach
            </select>
            <select name="ministry" class="filter-select" onchange="this.form.submit()">
                <option value="">All Ministries</option>
                @foreach ($ministries as $ministry)
                    <option value="{{ $ministry }}" @selected(($filters['ministry'] ?? '') === $ministry)>{{ $ministry }}</option>
                @endforeach
            </select>
            @if (($filters['search'] ?? null) || ($filters['status'] ?? null) || ($filters['role'] ?? null) || ($filters['ministry'] ?? null))
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-filter">Clear</a>
            @endif
        </form>

        {{-- MEMBERS TABLE --}}
        <div class="table-wrapper">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>PHONE</th>
                        <th>ROLE</th>
                        <th>MINISTRY</th>
                        <th>STATUS</th>
                        <th>JOINED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                    <tr>
                        <td>
                            <span class="table-cell-name">{{ $member->name ?? ($member->first_name . ' ' . $member->last_name) }}</span>
                        </td>
                        <td>{{ $member->email ?? '-' }}</td>
                        <td>{{ $member->phone ?? $member->contact_number ?? '-' }}</td>
                        <td>
                            @forelse ($member->roles as $role)
                                <span class="role-badge {{ Str::slug($role->name) }}">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="role-badge unassigned">No Role</span>
                            @endforelse
                        </td>
                        <td>
                            <span class="ministry-text">{{ $member->ministryNames() }}</span>
                        </td>
                        <td>
                            @php
                                $statusName = $member->memberStatus?->name ?? 'No Status';
                                $statusClass = match($statusName) {
                                    'Active' => 'active',
                                    'Inactive' => 'inactive',
                                    'Visitor' => 'visitor',
                                    default => 'pending'
                                };
                            @endphp
                            <div class="status-indicator">
                                <span class="status-dot {{ $statusClass }}"></span>
                                <span class="status-text">{{ $statusName }}</span>
                            </div>
                        </td>
                        <td>{{ $member->date_joined ? $member->date_joined : $member->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="table-cell-actions">
                                <a href="{{ route('admin.members.show', $member->id) }}" class="action-btn eye-btn" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.members.edit', $member->id) }}" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this member?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999; padding: 40px;">
                            <i class="bi bi-inbox" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                            No members found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}
            @if ($members->hasPages())
            <div class="table-pagination">
                <span class="pagination-info">
                    Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} members
                </span>
                <div class="pagination-controls">
                    @if ($members->onFirstPage())
                        <button class="pagination-btn" disabled>
                            <i class="bi bi-chevron-left"></i>
                        </button>
                    @else
                        <a href="{{ $members->previousPageUrl() }}" class="pagination-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    <span class="pagination-info-short">Page {{ $members->currentPage() }} of {{ $members->lastPage() }}</span>

                    @if ($members->hasMorePages())
                        <a href="{{ $members->nextPageUrl() }}" class="pagination-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <button class="pagination-btn" disabled>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        .admin-members-page {
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

        .filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-input,
        .filter-select {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: var(--white);
            color: var(--text-dark);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 250px;
        }

        .search-box i {
            color: var(--text-muted);
        }

        .filter-select {
            min-width: 150px;
            cursor: pointer;
        }

        .btn-filter {
            min-height: 42px;
        }

        /* LIGHT TABLE STYLING */
        .table-wrapper {
            overflow-x: auto;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            min-height: calc(100vh - 260px);
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

        .table-cell-avatar {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .table-cell-name {
            font-weight: 500;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #a0aec0;
            color: white;
            margin: 2px 4px 2px 0;
        }

        .role-badge.admin {
            background: #667eea;
        }

        .role-badge.pastor {
            background: #f59e0b;
        }

        .role-badge.member {
            background: #48bb78;
        }

        .role-badge.unassigned {
            background: #94a3b8;
        }

        .ministry-text {
            color: #6b7280;
            font-size: 13px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e0;
        }

        .status-dot.pending {
            background: #f6ad55;
        }

        .status-dot.active {
            background: #48bb78;
        }

        .status-dot.inactive {
            background: #ef4444;
        }

        .status-dot.visitor {
            background: #60a5fa;
        }

        .status-text {
            color: #6b7280;
        }

        .table-cell-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .action-btn:hover {
            background: #e2e8f0;
        }

        .action-btn.eye-btn:hover {
            color: #3b82f6;
        }

        .action-btn.edit-btn:hover {
            color: #f59e0b;
        }

        .action-btn.delete-btn:hover {
            color: #ef4444;
        }

        .table-pagination {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border);
            background: white;
            font-size: 13px;
            color: var(--text-muted);
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pagination-btn {
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

        .pagination-btn:hover:not(:disabled) {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .page-header .btn {
                align-self: stretch;
            }

            .filter-bar {
                flex-direction: column;
            }

            .search-box {
                min-width: auto;
            }

            .filter-select {
                width: 100%;
            }

            .table-pagination {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</x-admin-layout>
