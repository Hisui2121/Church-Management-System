<x-admin-layout>
    <x-slot:title>Edit Service Session</x-slot:title>

    <div class="page-container">
        <div class="breadcrumb">
            <a href="{{ route('admin.attendance.sessions.index') }}">Service Sessions</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Edit</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Service Session</h3>
                <p class="card-subtitle">Update service session details</p>
            </div>

            <form action="{{ route('admin.attendance.sessions.update', $session->id) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h4 class="section-title">Session Details</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Service Date & Time</label>
                            <input type="datetime-local" name="session_date" class="form-input" required 
                                value="{{ $session->session_date ? $session->session_date->format('Y-m-d\TH:i') : old('session_date') }}">
                            @error('session_date') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Service Title</label>
                            <input type="text" name="service_title" class="form-input" placeholder="e.g., Sunday Service" 
                                value="{{ $session->service_title ?? old('service_title') }}">
                            @error('service_title') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pastor</label>
                            <select name="pastor_id" class="form-input">
                                <option value="">-- Select Pastor (Optional) --</option>
                                @foreach($pastors as $pastor)
                                    <option value="{{ $pastor->id }}" {{ $session->pastor_id == $pastor->id ? 'selected' : '' }}>
                                        {{ $pastor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pastor_id') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Verse/Scripture Reference</label>
                            <input type="text" name="verse" class="form-input" placeholder="e.g., John 3:16" 
                                value="{{ $session->verse ?? old('verse') }}">
                            @error('verse') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="checkbox-wrapper">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" id="isActive" class="form-checkbox" 
                                    {{ $session->is_active ? 'checked' : '' }}>
                                <label for="isActive" class="checkbox-label">Active Session</label>
                            </div>
                            @error('is_active') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">Session Information</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Started By:</span>
                            <span class="info-value">{{ $session->startedBy->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Started At:</span>
                            <span class="info-value">{{ $session->started_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($session->ended_at)
                        <div class="info-item">
                            <span class="info-label">Ended At:</span>
                            <span class="info-value">{{ $session->ended_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <span class="info-label">Attendees:</span>
                            <span class="info-value">{{ $session->attendances()->count() ?? 0 }} checked in</span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Update Session
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

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--text-dark);
            cursor: pointer;
        }

        .error-text {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            background: #f9fafb;
            padding: 16px;
            border-radius: 8px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
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

            .info-grid {
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
