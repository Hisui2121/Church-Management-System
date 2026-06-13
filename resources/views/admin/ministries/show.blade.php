<x-admin-layout>
    <x-slot:title>Assign Members</x-slot:title>

    <div class="admin-members-page">
        <div class="breadcrumb">
            <a href="{{ route('admin.ministries.index') }}">Ministries</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $ministry->name }}</span>
        </div>

        <div class="page-header">
            <div>
                <h1 class="page-title">Assign Members</h1>
                <p class="page-subtitle">{{ $ministry->name }} - {{ $ministry->description ?? 'Manage ministry assignments' }}</p>
            </div>
            <a href="{{ route('admin.ministries.show', ['ministry' => $ministry, 'add' => 1]) }}#add-members" class="btn btn-secondary">
                <i class="bi bi-person-plus"></i> Add Member
            </a>
        </div>

        <form method="GET" action="{{ route('admin.ministries.show', $ministry) }}" class="filter-bar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search members..." class="filter-input">
            </div>
            <select name="ministry_role" class="filter-select" onchange="this.form.submit()">
                <option value="">All Ministry Roles</option>
                <option value="Leader" @selected(($filters['ministry_role'] ?? '') === 'Leader')>Leader</option>
                <option value="Member" @selected(($filters['ministry_role'] ?? '') === 'Member')>Member</option>
            </select>
            @if (($filters['search'] ?? null) || ($filters['status'] ?? null))
                <a href="{{ route('admin.ministries.show', $ministry) }}" class="btn btn-secondary btn-filter">Clear</a>
            @endif
        </form>

        @if ($showAddMembers)
            <div class="add-members-panel" id="add-members">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">Add Existing Member</h2>
                        <p class="panel-subtitle">Assign an existing system member to {{ $ministry->name }}</p>
                    </div>
                    <a href="{{ route('admin.ministries.show', $ministry) }}" class="btn btn-secondary">Close</a>
                </div>

                <div class="table-wrapper add-members-table">
                    <table class="table-dark">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Church Role</th>
                                <th>Status</th>
                                <th>Ministry Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($availableMembers as $availableMember)
                                @php
                                    $availableStatusName = $availableMember->memberStatus?->name ?? 'No Status';
                                    $availableStatusClass = match($availableStatusName) {
                                        'Active' => 'active',
                                        'Inactive' => 'inactive',
                                        'Visitor' => 'visitor',
                                        default => 'pending'
                                    };
                                @endphp
                                <tr>
                                    <td><span class="table-cell-name">{{ $availableMember->name }}</span></td>
                                    <td>{{ $availableMember->email ?? '-' }}</td>
                                    <td>
                                        @forelse ($availableMember->roles as $role)
                                            <span class="role-badge {{ Str::slug($role->name) }}">{{ $role->name }}</span>
                                        @empty
                                            <span class="role-badge unassigned">No Role</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="status-indicator">
                                            <span class="status-dot {{ $availableStatusClass }}"></span>
                                            <span class="status-text">{{ $availableStatusName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <form id="add-member-{{ $availableMember->id }}" action="{{ route('admin.ministries.members.assign', [$ministry, $availableMember]) }}" method="POST">
                                            @csrf
                                            <select name="ministry_role" class="filter-select ministry-role-select" required>
                                                <option value="Leader">Leader</option>
                                                <option value="Member">Member</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="submit" form="add-member-{{ $availableMember->id }}" class="action-btn edit-btn" title="Add Member">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-cell">
                                        <i class="bi bi-inbox"></i>
                                        No existing members available to add
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="table-wrapper">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Church Role</th>
                        <th>Status</th>
                        <th>Ministry Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        @php
                            $assignedMinistry = $member->member?->ministries->firstWhere('id', $ministry->id);
                            $ministryRole = $assignedMinistry?->pivot?->role;
                            $selectedMinistryRole = in_array($ministryRole, $ministryRoles, true) ? $ministryRole : 'Member';
                            $statusName = $member->memberStatus?->name ?? 'No Status';
                            $statusClass = match($statusName) {
                                'Active' => 'active',
                                'Inactive' => 'inactive',
                                'Visitor' => 'visitor',
                                default => 'pending'
                            };
                        @endphp
                        <tr>
                            <td><span class="table-cell-name">{{ $member->name }}</span></td>
                            <td>{{ $member->email ?? '-' }}</td>
                            <td>
                                @forelse ($member->roles as $role)
                                    <span class="role-badge {{ Str::slug($role->name) }}">{{ $role->name }}</span>
                                @empty
                                    <span class="role-badge unassigned">No Role</span>
                                @endforelse
                            </td>
                            <td>
                                <div class="status-indicator">
                                    <span class="status-dot {{ $statusClass }}"></span>
                                    <span class="status-text">{{ $statusName }}</span>
                                </div>
                            </td>
                            <td>
                                <form id="update-member-role-{{ $member->id }}" action="{{ route('admin.ministries.members.assign', [$ministry, $member]) }}" method="POST">
                                    @csrf
                                    <select name="ministry_role" class="filter-select ministry-role-select" onchange="document.getElementById('update-member-role-{{ $member->id }}').submit()">
                                        <option value="Leader" @selected($selectedMinistryRole === 'Leader')>Leader</option>
                                        <option value="Member" @selected($selectedMinistryRole === 'Member')>Member</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="table-cell-actions">
                                    <form action="{{ route('admin.ministries.members.remove', [$ministry, $member]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" title="Remove Member" onclick="return confirm('Remove this member from {{ $ministry->name }}?')">
                                            <i class="bi bi-person-dash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-cell">
                                <i class="bi bi-inbox"></i>
                                No members found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($members->hasPages())
                <div class="table-pagination">
                    <span class="pagination-info">
                        Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} members
                    </span>
                    <div class="pagination-controls">
                        @if ($members->onFirstPage())
                            <button class="pagination-btn" disabled><i class="bi bi-chevron-left"></i></button>
                        @else
                            <a href="{{ $members->previousPageUrl() }}" class="pagination-btn"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        <span class="pagination-info-short">Page {{ $members->currentPage() }} of {{ $members->lastPage() }}</span>

                        @if ($members->hasMorePages())
                            <a href="{{ $members->nextPageUrl() }}" class="pagination-btn"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <button class="pagination-btn" disabled><i class="bi bi-chevron-right"></i></button>
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

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
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

        .add-members-panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .panel-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .ministry-role-select {
            min-width: 120px;
            padding: 8px 10px;
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            min-height: calc(100vh - 260px);
        }

        .add-members-table {
            border: none;
            border-radius: 0;
            min-height: 0;
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
        }

        .table-dark tbody td {
            padding: 16px 20px;
            font-size: 14px;
            color: #374151;
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

        .table-cell-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
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

        .action-btn i {
            display: block;
            line-height: 1;
        }

        .action-btn:hover {
            background: #e2e8f0;
        }

        .action-btn.edit-btn:hover {
            color: #10b981;
        }

        .action-btn.delete-btn:hover {
            color: #ef4444;
        }

        .empty-cell {
            text-align: center;
            color: #999;
            padding: 40px !important;
        }

        .empty-cell i {
            display: block;
            font-size: 32px;
            margin-bottom: 10px;
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

            .filter-bar {
                flex-direction: column;
            }

            .search-box {
                min-width: auto;
            }

            .filter-select {
                width: 100%;
            }

            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-pagination {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</x-admin-layout>
