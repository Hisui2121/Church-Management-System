{{-- resources/views/admin/users/edit.blade.php --}}

<x-admin-layout>

<x-slot:title>
    {{ $title }}
</x-slot:title>

<div class="form-container">
    <div class="form-card">
        <h2 class="form-title">
            <i class="bi bi-pencil-square me-2"></i> Edit User
        </h2>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="form">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    required
                >
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    required
                >
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Current Role --}}
            <div class="form-group">
                <label class="form-label">Current Role</label>
                <p class="current-value">
                    <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isPastor() ? 'warning' : 'info') }}">
                        {{ $user->role->name ?? 'Unknown' }}
                    </span>
                </p>
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role_id" class="form-label">Change Role To</label>
                <select 
                    id="role_id" 
                    name="role_id" 
                    class="form-control @error('role_id') is-invalid @enderror"
                    required
                >
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 30px;
    }

    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(103, 182, 158, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc2626;
    }

    .invalid-feedback {
        display: block;
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .current-value {
        margin: 0;
        padding: 10px 14px;
        background: #f3f4f6;
        border-radius: 8px;
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

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        justify-content: flex-end;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }
</style>

</x-admin-layout>
