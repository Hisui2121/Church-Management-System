<x-admin-layout>
    <x-slot:title>Edit Event</x-slot:title>

    <div class="event-edit-page">
        <div class="breadcrumb">
            <a href="{{ route('admin.events.index') }}">Events</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Edit</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Event</h3>
                <p class="card-subtitle">Update event information</p>
            </div>

            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" class="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h4 class="section-title">Event Details</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Event Name</label>
                            <input type="text" name="name" class="form-input" required value="{{ old('name', $event->name) }}">
                            @error('name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="4">{{ old('description', $event->description) }}</textarea>
                            @error('description') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" name="event_date" class="form-input" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}">
                            @error('event_date') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Time</label>
                            <input type="time" name="event_time" class="form-input" value="{{ old('event_time', $event->event_time) }}">
                            @error('event_time') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Event Image</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="image" class="form-input file-input" id="eventImage" accept="image/*">
                                <label for="eventImage" class="file-input-label">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Click to upload or drag and drop</span>
                                    <small>PNG, JPG, GIF up to 2MB</small>
                                </label>
                                @if ($event->image_path)
                                <div class="current-image">
                                    <p class="text-muted">Current Image:</p>
                                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}" class="current-preview">
                                </div>
                                @endif
                                <img id="imagePreview" class="image-preview" style="display: none;">
                            </div>
                            @error('image') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .event-edit-page {
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

        .file-input-wrapper {
            position: relative;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .file-input-label:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .file-input-label i {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .file-input-label span {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .file-input-label small {
            color: var(--text-muted);
            font-size: 12px;
            margin-top: 4px;
        }

        .current-image {
            margin-top: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .current-image p {
            margin: 0 0 8px 0;
            font-size: 12px;
        }

        .current-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 6px;
        }

        .image-preview {
            max-width: 400px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 12px;
        }

        .text-muted {
            color: var(--text-muted);
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
            font-weight: 500;
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

    <script>
        const fileInput = document.getElementById('eventImage');
        const fileInputLabel = document.querySelector('.file-input-label');
        const imagePreview = document.getElementById('imagePreview');

        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        imagePreview.src = event.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            fileInputLabel.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileInputLabel.style.borderColor = 'var(--primary)';
                fileInputLabel.style.background = 'var(--primary-light)';
            });

            fileInputLabel.addEventListener('dragleave', () => {
                fileInputLabel.style.borderColor = 'var(--border)';
                fileInputLabel.style.background = '#f9fafb';
            });

            fileInputLabel.addEventListener('drop', (e) => {
                e.preventDefault();
                fileInputLabel.style.borderColor = 'var(--border)';
                fileInputLabel.style.background = '#f9fafb';
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            });
        }
    </script>
</x-admin-layout>
