<x-admin-layout>
    <x-slot:title>Add New Event</x-slot:title>

    <div class="event-create-page">
        <div class="breadcrumb">
            <a href="{{ route('admin.events.index') }}">Events</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Add New</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Event</h3>
                <p class="card-subtitle">Create a new church event or service</p>
            </div>

            <form action="{{ route('admin.events.store') }}" method="POST" class="form" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <h4 class="section-title">Event Details</h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Event Name</label>
                            <input type="text" name="name" class="form-input" required value="{{ old('name') }}">
                            @error('name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="4">{{ old('description') }}</textarea>
                            @error('description') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" name="event_date" class="form-input" value="{{ old('event_date') }}">
                            @error('event_date') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Time</label>
                            <input type="time" name="event_time" class="form-input" value="{{ old('event_time') }}">
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
                                <img id="imagePreview" class="image-preview" style="display: none;">
                            </div>
                            @error('image') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .event-create-page {
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

        .full-width {
            grid-column: 1 / -1;
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
            transition: all 0.3s ease;
            gap: 8px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .file-input-label:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }

        .file-input-label i {
            font-size: 32px;
        }

        .file-input-label small {
            font-size: 12px;
            color: inherit;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            margin-top: 16px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }
    </style>

    <script>
        const fileInput = document.getElementById('eventImage');
        const imagePreview = document.getElementById('imagePreview');
        const fileLabel = document.querySelector('.file-input-label');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                    fileLabel.style.display = 'none';
                }
            });

            // Drag and drop
            fileLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--primary)';
                this.style.background = 'var(--primary-light)';
            });

            fileLabel.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--border)';
                this.style.background = 'transparent';
            });

            fileLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--border)';
                this.style.background = 'transparent';
                const files = e.dataTransfer.files;
                if (files && files[0]) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });
        }
    </script>
</x-admin-layout>
