<x-admin-layout>

<x-slot:title>
    Edit Permissions - {{ $user->name }}
</x-slot:title>

<div class="roles-edit-page">

    <div class="page-header">
        <h1 class="page-title">Edit Permissions</h1>
        <p class="page-subtitle">{{ $user->name }} &lt;{{ $user->email }}&gt;</p>
    </div>

    <div class="permissions-card">

        <form method="POST" action="{{ route('admin.permissions.update', $user) }}" class="permissions-form">
            @csrf
            @method('PUT')

            <p class="form-description">
                Check the actions this user account is allowed to perform.
                Admins always have full access regardless of these settings.
            </p>

            @php $current = $user->getDirectPermissions()->pluck('name')->toArray(); @endphp

            @if($user->isAdmin())
            <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#92400e;">
                <i class="bi bi-info-circle-fill"></i>
                This user is an <strong>Admin</strong> and has full access to everything. Permissions cannot be restricted.
            </div>
            @endif

            <div class="permissions-list">
                @foreach($available as $key => $label)
                    <label class="permission-item">
                        <input
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $key }}"
                            {{ $user->isAdmin() || in_array($key, $current) ? 'checked' : '' }}
                            {{ $user->isAdmin() ? 'disabled' : '' }}
                            class="permission-checkbox"
                        >
                        <div class="permission-content">
                            <div class="permission-label">{{ $label }}</div>
                            <div class="permission-key">{{ $key }}</div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" {{ $user->isAdmin() ? 'disabled' : '' }}>
                    <i class="bi bi-check"></i> Save Permissions
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x"></i> Cancel
                </a>
            </div>
        </form>

    </div>

</div>

<style>
    .roles-edit-page {
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

    .permissions-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        max-width: 640px;
    }

    .form-description {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .permissions-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 24px;
    }

    .permission-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        padding: 12px 16px;
        border: 1px solid var(--border);
        border-radius: 8px;
        transition: all 0.15s ease;
    }

    .permission-item:hover {
        background: #f9fafb;
        border-color: var(--primary);
    }

    .permission-checkbox {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .permission-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .permission-label {
        font-weight: 600;
        font-size: 14px;
        color: var(--text-dark);
    }

    .permission-key {
        font-size: 12px;
        color: var(--text-muted);
        font-family: monospace;
    }

    .form-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-secondary {
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: #f9fafb;
    }
</style>

</x-admin-layout>
