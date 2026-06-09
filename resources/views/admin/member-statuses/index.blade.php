<x-admin-layout>

<x-slot:title>
    User Permissions
</x-slot:title>

<div class="roles-page">

    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-shield-check-fill me-2"></i> User Permissions
        </h1>
        <p class="page-subtitle">Define what each user account is allowed to do across the system</p>
    </div>

    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Member Status</th>
                    <th>Permissions Granted</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            <div style="color:#9ca3af;font-size:12px;margin-top:2px;">{{ $user->email }}</div>
                        </td>
                        <td>{{ $user->role?->name ?? 'No role' }}</td>
                        <td>{{ $user->memberStatus?->name ?? 'No status' }}</td>
                        <td>
                            @php $perms = $user->permissions ?? []; @endphp
                            @if($user->isAdmin())
                                <span style="background:#e0f2fe;color:#075985;font-size:12px;padding:2px 10px;border-radius:999px;font-weight:500;">
                                    Full access
                                </span>
                            @elseif(count($perms) > 0)
                                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                    @foreach($perms as $perm)
                                        <span style="background:#dcfce7;color:#166534;font-size:12px;padding:2px 10px;border-radius:999px;font-weight:500;">
                                            {{ $available[$perm] ?? $perm }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:#9ca3af;font-size:13px;">No permissions assigned</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.permissions.edit', $user) }}"
                               class="btn btn-primary">
                                Edit Permissions
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<style>
    .roles-page {
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

    .success-box {
        background: #d1fae5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        color: #065f46;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px;
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
        vertical-align: top;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #67b69e;
        color: white;
    }

    .btn-primary:hover {
        background: #5a9d87;
    }
</style>

</x-admin-layout>
