<x-admin-layout>

<x-slot:title>
    Edit Permissions - {{ $role->name }}
</x-slot:title>

<div class="roles-edit-page">

    <div class="page-header">
        <h1 class="page-title">Edit Permissions</h1>
        <p class="page-subtitle">Role: {{ $role->name }}</p>
    </div>

    <div class="permissions-card">

        <form method="POST" action="{{ route('admin.permissions.update', $role) }}" class="permissions-form">
            @csrf
            @method('PUT')

            <p class="form-description">
                Click a page below to reveal and toggle the actions users with this role are allowed to perform on it.
                The Admin role always has full access regardless of these settings.
            </p>

            @php $current = $role->permissions->pluck('name')->toArray(); @endphp
            @php $isAdmin = $role->name === 'Admin'; @endphp

            @if($role->name === 'Admin')
            <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#92400e;">
                <i class="bi bi-info-circle-fill"></i>
                The <strong>Admin</strong> role always has full access to everything. Permissions cannot be restricted.
            </div>
            @endif

            <div class="permissions-groups">
                @foreach($grouped as $group)
                    @php
                        $pagePerms = array_keys($group['permissions']);
                        $checkedCount = collect($pagePerms)->filter(fn($p) => $isAdmin || in_array($p, $current))->count();
                        $totalCount = count($pagePerms);
                    @endphp
                    <div class="permission-group">
                        <button type="button" class="group-header" onclick="this.parentElement.classList.toggle('open')">
                            <div class="group-header-left">
                                <i class="bi bi-chevron-right group-chevron"></i>
                                <span class="group-title">{{ $group['page'] }}</span>
                            </div>
                            <span class="group-count">{{ $checkedCount }}/{{ $totalCount }} enabled</span>
                        </button>

                        <div class="group-body">
                            <div class="permissions-list">
                                @foreach($group['permissions'] as $key => $label)
                                    <label class="permission-item">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $key }}"
                                            {{ $isAdmin || in_array($key, $current) ? 'checked' : '' }}
                                            {{ $isAdmin ? 'disabled' : '' }}
                                            class="permission-checkbox"
                                        >
                                        <div class="permission-content">
                                            <div class="permission-label">{{ $label }}</div>
                                            <div class="permission-key">{{ $key }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" {{ $isAdmin ? 'disabled' : '' }}>
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

    .permissions-groups {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 24px;
    }

    .permission-group {
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .group-header {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        background: #f9fafb;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        transition: background 0.15s ease;
    }

    .group-header:hover {
        background: #f3f4f6;
    }

    .group-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .group-chevron {
        transition: transform 0.15s ease;
        font-size: 12px;
        color: var(--text-muted);
    }

    .permission-group.open .group-chevron {
        transform: rotate(90deg);
    }

    .group-count {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-muted);
    }

    .group-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease;
    }

    .permission-group.open .group-body {
        max-height: 600px;
    }

    .permissions-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 14px 16px;
    }

    .permission-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        padding: 10px 14px;
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
