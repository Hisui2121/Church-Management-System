{{-- resources/views/admin/users/change-password.blade.php --}}

<x-admin-layout>

<x-slot:title>
    {{ $title }}
</x-slot:title>

<div class="form-container">
    <div class="form-card">
        <h2 class="form-title">
            <i class="bi bi-key-fill me-2"></i> Change Password
        </h2>
        <p class="form-subtitle">Update password for {{ $user->name }}</p>

        <form method="POST" action="{{ route('admin.users.updatePassword', $user) }}" class="form">
            @csrf
            @method('PUT')

            {{-- New Password --}}
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    minlength="8"
                    autocomplete="new-password"
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
                    autocomplete="new-password"
                >
                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Info Box --}}
            <div class="info-box">
                <i class="bi bi-info-circle me-2"></i>
                <div>
                    <strong>Password Requirements:</strong>
                    <ul>
                        <li>Minimum 8 characters long</li>
                        <li>Both passwords must match</li>
                        <li>User will need to use this new password to log in</li>
                    </ul>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Password
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
        margin: 0 0 8px 0;
    }

    .form-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0 0 30px 0;
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
        display: block;
        color: var(--text-muted);
        font-size: 12px;
        margin-top: 4px;
    }

    .info-box {
        display: flex;
        gap: 12px;
        padding: 16px 14px;
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        border-radius: 8px;
        margin: 30px 0;
        font-size: 13px;
        color: #1e3a8a;
    }

    .info-box i {
        color: #3b82f6;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-box strong {
        display: block;
        margin-bottom: 8px;
    }

    .info-box ul {
        margin: 0;
        padding-left: 20px;
    }

    .info-box li {
        margin: 4px 0;
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
