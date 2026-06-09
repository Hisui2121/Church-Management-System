{{-- resources/views/admin/users/index.blade.php --}}

<x-admin-layout>

<x-slot:title>
    {{ $title }}
</x-slot:title>

<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="bi bi-people-fill me-2"></i> System Users
            </h1>
            <p class="page-subtitle">Manage system users and their roles</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add User
        </a>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="font-weight-500">
                            {{ $user->name }}
                        </td>

                        <td class="text-muted small">
                            {{ $user->email }}
                        </td>

                        <td>
                            <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isPastor() ? 'warning' : 'info') }}">
                                {{ $user->role->name ?? 'Unknown' }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('admin.users.changePassword', $user) }}" class="btn btn-sm btn-secondary" title="Change Password">
                                    <i class="bi bi-key"></i>
                                </a>
                                @if (auth()->id() !== $user->id)
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999; padding: 40px;">
                            No users found. <a href="{{ route('admin.users.create') }}">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    @endif

</div>

<style>
    .page-section {
        padding: 0;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
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

    .table-wrapper {
        overflow-x: auto;
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
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

    .font-weight-500 {
        font-weight: 500;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border: 1px solid transparent;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        gap: 4px;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 11px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-info:hover {
        background: #bfdbfe;
    }

    .btn-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-warning:hover {
        background: #fde68a;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    .text-muted {
        color: #9ca3af;
    }

    .small {
        font-size: 12px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 20px;
        }

        .page-title {
            font-size: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

</x-admin-layout>
