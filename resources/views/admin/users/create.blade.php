{{-- resources/views/admin/users/create.blade.php --}}

<x-admin-layout>

<x-slot:title>
    {{ $title }}
</x-slot:title>

<div class="form-container">
    <div class="form-card">
        <h2 class="form-title">
            <i class="bi bi-person-plus-fill me-2"></i> Create New User
        </h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="form">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
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
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role_name" class="form-label">Role</label>
                <select 
                    id="role_name" 
                    name="role_name" 
                    class="form-control @error('role_name') is-invalid @enderror"
                    required
                >
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected(old('role_name') === $role->name)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>


            {{-- Member Status --}}
            <div class="form-group">
                <label for="member_status_id" class="form-label">
                    Member Status
                    <span class="label-hint">Controls what this user can access</span>
                </label>
                <select
                    id="member_status_id"
                    name="member_status_id"
                    class="form-control @error('member_status_id') is-invalid @enderror"
                >
                    <option value="">-- No Status (Admin/Pastor) --</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" @selected(old('member_status_id') == $status->id)>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_status_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">
                    Permissions are assigned per user from the Permissions tab.
                </small>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    minlength="8"
                >
                <small class="text-muted">Minimum 8 characters</small>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control"
                    required
                    minlength="8"
                >
                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create User
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

    .text-muted {
        color: var(--text-muted);
        font-size: 12px;
    }

    .label-hint {
        display: block;
        font-size: 11px;
        font-weight: 400;
        color: var(--text-muted);
        margin-top: 2px;
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
