<x-admin-layout>

<x-slot:title>
    Roles &amp; Permissions
</x-slot:title>

<div class="roles-page">

    <div class="breadcrumb" style="margin-bottom:12px;">
        <a href="{{ route('admin.members.index') }}">Members</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Roles &amp; Permissions</span>
    </div>

    <div class="page-header">
        <div class="page-header-row">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-shield-check-fill me-2"></i> Roles &amp; Permissions
                </h1>
                <p class="page-subtitle">Define roles and what each role is allowed to do across the system</p>
            </div>
            <button type="button" class="btn btn-primary" onclick="openAddRoleModal()">
                <i class="bi bi-plus-lg"></i> Add Role
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-box">{{ session('error') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions Granted</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td><strong>{{ $role->name }}</strong></td>
                        <td>
                            @php $perms = $role->permissions->pluck('name')->toArray(); @endphp
                            @if($role->name === 'Admin')
                                <span style="background:#e0f2fe;color:#075985;font-size:12px;padding:2px 10px;border-radius:999px;font-weight:500;">
                                    Full access
                                </span>
                            @elseif(count($perms) > 0)
                                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                    @foreach($perms as $perm)
                                        <span style="background:#dcfce7;color:#166534;font-size:12px;padding:2px 10px;border-radius:999px;font-weight:500;">
                                            {{ $available[$perm] ?? ucwords(str_replace('_', ' ', $perm)) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:#9ca3af;font-size:13px;">No permissions assigned</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.permissions.edit', $role) }}"
                               class="btn btn-primary">
                                Edit Permissions
                            </a>

                            @unless(in_array($role->name, ['Admin', 'Pastor', 'Member']))
                                <form method="POST" action="{{ route('admin.permissions.destroy', $role) }}"
                                      style="display:inline;" onsubmit="return confirm('Delete the &quot;{{ $role->name }}&quot; role? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ============================================================
     ADD ROLE MODAL
     ============================================================ --}}
<div id="addRoleModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-container">

        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-icon">
                <i class="bi bi-shield-plus"></i>
            </div>
            <div>
                <h2 class="modal-title" id="modalTitle">Add New Role</h2>
                <p class="modal-subtitle">Create a custom role you can assign to users</p>
            </div>
            <button type="button" class="modal-close" onclick="closeAddRoleModal()" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Body --}}
        <form method="POST" action="{{ route('admin.permissions.store') }}" id="addRoleForm">
            @csrf
            <div class="modal-body">
                <label for="roleNameInput" class="modal-label">Role Name</label>
                <input
                    type="text"
                    id="roleNameInput"
                    name="name"
                    placeholder="e.g. Volunteer, Treasurer, Youth Leader"
                    class="modal-input @error('name') modal-input-error @enderror"
                    autocomplete="off"
                    maxlength="255"
                >
                @error('name')
                    <div class="field-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
                <p class="modal-hint">Use a clear, descriptive name. You can assign permissions to this role after creating it.</p>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeAddRoleModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Create Role
                </button>
            </div>
        </form>

    </div>
</div>

<style>
    /* ── Page Layout ─────────────────────────────── */
    .roles-page {
        padding: 0;
    }

    .page-header {
        margin-bottom: 28px;
    }

    .page-header-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
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

    /* ── Alerts ──────────────────────────────────── */
    .success-box {
        background: #d1fae5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        color: #065f46;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .error-box {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        color: #991b1b;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* ── Buttons ─────────────────────────────────── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-primary {
        background: #67b69e;
        color: white;
    }

    .btn-primary:hover {
        background: #5a9d87;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        margin-left: 8px;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    /* ── Table ───────────────────────────────────── */
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

    /* ── Modal Overlay ───────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(2px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: overlayFadeIn 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes overlayFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Modal Container ─────────────────────────── */
    .modal-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
        width: 100%;
        max-width: 480px;
        animation: modalSlideIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(-20px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)    scale(1);    }
    }

    /* ── Modal Header ────────────────────────────── */
    .modal-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 24px 24px 0;
    }

    .modal-header-icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--primary-light, #e8f5f0);
        color: var(--primary, #67b69e);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-top: 2px;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 2px 0;
    }

    .modal-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    .modal-close {
        margin-left: auto;
        flex-shrink: 0;
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        font-size: 16px;
        padding: 4px;
        border-radius: 6px;
        transition: color 0.15s, background 0.15s;
        line-height: 1;
    }

    .modal-close:hover {
        color: #374151;
        background: #f3f4f6;
    }

    /* ── Modal Body ──────────────────────────────── */
    .modal-body {
        padding: 24px;
    }

    .modal-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .modal-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border, #ececec);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        color: var(--text-dark);
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .modal-input:focus {
        outline: none;
        border-color: var(--primary, #67b69e);
        box-shadow: 0 0 0 3px rgba(103, 182, 158, 0.15);
    }

    .modal-input-error {
        border-color: #ef4444;
    }

    .modal-input-error:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
    }

    .modal-hint {
        margin: 8px 0 0;
        font-size: 12px;
        color: var(--text-muted);
    }

    .field-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    /* ── Modal Footer ────────────────────────────── */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 24px 24px;
        border-top: 1px solid var(--border, #ececec);
        padding-top: 16px;
        margin-top: -1px;
    }
</style>

<script>
    function openAddRoleModal() {
        const modal = document.getElementById('addRoleModal');
        modal.classList.add('active');
        // Focus the input after the animation settles
        setTimeout(() => document.getElementById('roleNameInput').focus(), 50);
    }

    function closeAddRoleModal() {
        const modal = document.getElementById('addRoleModal');
        modal.classList.remove('active');
    }

    // Close on backdrop click
    document.getElementById('addRoleModal').addEventListener('click', function (e) {
        if (e.target === this) closeAddRoleModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAddRoleModal();
    });

    // Auto-open if there was a validation error on 'name'
    @if($errors->has('name'))
        document.addEventListener('DOMContentLoaded', openAddRoleModal);
    @endif
</script>

</x-admin-layout>
