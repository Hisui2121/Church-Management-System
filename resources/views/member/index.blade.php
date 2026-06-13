<x-layout>

<x-slot:title>
    Members
</x-slot:title>

<div class="members-page">
    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Members</h1>
            <p class="page-subtitle">Manage and view all church members</p>
        </div>
        @can('create', App\Models\Member::class)
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Member
        </a>
        @endcan
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTERS & SEARCH --}}
    <div class="filter-bar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search members..." class="filter-input">
        </div>
        <select class="filter-select">
            <option>All Status</option>
            <option>Active</option>
            <option>Inactive</option>
            <option>Visitor</option>
        </select>
    </div>

    {{-- MEMBERS TABLE --}}
    <div class="table-wrapper">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>STATUS</th>
                    <th>JOINED</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        <span class="table-cell-name">{{ $member->name ?? ($member->first_name . ' ' . $member->last_name) }}</span>
                    </td>
                    <td>{{ $member->email ?? '-' }}</td>
                    <td>{{ $member->phone ?? '-' }}</td>
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
                    <td>{{ $member->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="table-cell-actions">
                            @can('view', $member)
                            <a href="{{ route('members.show', $member) }}" class="action-btn eye-btn" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endcan

                            @can('update', $member)
                            <a href="{{ route('members.edit', $member) }}" class="action-btn edit-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan

                            @can('delete', $member)
                            <form action="{{ route('members.destroy', $member) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this member?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #999; padding: 40px;">
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
    .members-page {
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

    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
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

    /* TABLE STYLING */
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

    .table-cell-name {
        font-weight: 500;
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
        text-decoration: none;
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
        text-decoration: none;
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

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .page-header .btn {
            align-self: stretch;
            justify-content: center;
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

</x-layout>
