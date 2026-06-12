{{-- resources/views/admin/users/show.blade.php --}}

<x-admin-layout>

<x-slot:title>
    {{ $title }}
</x-slot:title>

<div class="user-details-container">
    <div class="back-link">
        <a href="{{ route('admin.users.index') }}">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>

    <div class="user-card">
        <div class="user-header">
            <div class="user-info">
                <h2 class="user-name">{{ $user->name }}</h2>
                <p class="user-email">{{ $user->email }}</p>
                <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isPastor() ? 'warning' : 'info') }}">
                    {{ $user->getRoleNames()->first() ?? 'No Role' }}
                </span>
            </div>
            <div class="user-actions">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit User
                </a>
                <a href="{{ route('admin.users.changePassword', $user) }}" class="btn btn-secondary">
                    <i class="bi bi-key"></i> Change Password
                </a>
            </div>
        </div>

        <div class="user-details">
            <div class="detail-group">
                <label>Email</label>
                <p>{{ $user->email }}</p>
            </div>

            <div class="detail-group">
                <label>Role</label>
                <p>{{ $user->roles->first()?->name ?? 'N/A' }}</p>
            </div>

            @if ($user->member)
                <div class="detail-group">
                    <label>Associated Member</label>
                    <p>
                        <a href="{{ route('admin.members.show', $user->member) }}">
                            {{ $user->member->first_name }} {{ $user->member->last_name }}
                        </a>
                    </p>
                </div>
            @endif

            @if ($user->memberStatus)
                <div class="detail-group">
                    <label>Member Status</label>
                    <p>{{ $user->memberStatus->name ?? 'N/A' }}</p>
                </div>
            @endif

            <div class="detail-group">
                <label>Account Created</label>
                <p>{{ $user->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <div class="detail-group">
                <label>Last Updated</label>
                <p>{{ $user->updated_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .user-details-container {
        padding: 0;
    }

    .back-link {
        margin-bottom: 20px;
    }

    .back-link a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .back-link a:hover {
        color: var(--primary-dark);
    }

    .user-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 30px;
    }

    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid var(--border);
    }

    .user-info h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 8px 0;
    }

    .user-email {
        color: var(--text-muted);
        font-size: 14px;
        margin: 0 0 12px 0;
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

    .user-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .user-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
    }

    .detail-group label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .detail-group p {
        font-size: 14px;
        color: var(--text-dark);
        margin: 0;
    }

    .detail-group a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .detail-group a:hover {
        text-decoration: underline;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        gap: 8px;
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

    @media (max-width: 768px) {
        .user-header {
            flex-direction: column;
            gap: 20px;
        }

        .user-actions {
            width: 100%;
        }

        .user-actions .btn {
            flex: 1;
        }

        .detail-group {
            gap: 4px;
        }
    }
</style>

</x-admin-layout>
