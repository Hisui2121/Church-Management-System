<x-admin-layout>
    <x-slot:title>Create Service Session</x-slot:title>

    <div class="page-container">
        <div class="breadcrumb">
            <a href="{{ route('admin.attendance.sessions.index') }}">Service Sessions</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">New</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create New Service Session</h3>
                <p class="card-subtitle">Create a new service session for member check-ins</p>
            </div>

            <form action="{{ route('admin.attendance.sessions.store') }}" method="POST" class="form">
                @csrf

                <div class="form-section">
                    <h4 class="section-title">Session Details</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Service Date & Time</label>
                            <input type="datetime-local" name="session_date" class="form-input" required value="{{ old('session_date') }}">
                            @error('session_date') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Service Title</label>
                            <input type="text" name="service_title" class="form-input" placeholder="e.g., Sunday Service, Midweek Worship" value="{{ old('service_title') }}">
                            @error('service_title') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pastor</label>
                            <input type="text" name="pastor_name" class="form-input" placeholder="Enter pastor name" value="{{ old('pastor_name') }}">
                            @error('pastor_name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Verse/Scripture Reference</label>
                            <input type="text" name="verse" class="form-input" placeholder="e.g., John 3:16" value="{{ old('verse') }}">
                            @error('verse') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Create Session
                    </button>
                    <a href="{{ route('admin.attendance.sessions.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .page-container {
            padding: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: var(--text-muted);
        }

        .breadcrumb-current {
            color: var(--text-dark);
        }

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .card-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .form {
            padding: 24px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .form-grid .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-label.required::after {
            content: ' *';
            color: var(--danger);
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-dark);
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .error-text {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-lg {
            padding: 12px 24px;
            font-size: 15px;
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

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</x-admin-layout>
