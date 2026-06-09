<x-admin-layout>
    <x-slot:title>Edit Banner</x-slot:title>

    <div class="banner-edit-page">
        <div class="breadcrumb">
            <a href="{{ route('admin.banners.index') }}">Banners</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Edit</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Banner</h3>
                <p class="card-subtitle">Update banner details and image</p>
            </div>

            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" class="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h4 class="section-title">Banner Details</h4>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Banner Image</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="image" class="form-input file-input" id="bannerImage" accept="image/*">
                                <label for="bannerImage" class="file-input-label">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Click to upload or drag and drop</span>
                                    <small>PNG, JPG, GIF up to 2MB (Recommended: 2018x608px)</small>
                                </label>
                                @if ($banner->image_path)
                                <div class="current-image">
                                    <p class="text-muted">Current Image:</p>
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="current-preview">
                                </div>
                                @endif
                                <img id="imagePreview" class="image-preview" style="display: none;">
                            </div>
                            @error('image') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-input" value="{{ old('title', $banner->title) }}" maxlength="255">
                            @error('title') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="order" class="form-input" value="{{ old('order', $banner->order) }}" min="0">
                            @error('order') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="3" maxlength="1000">{{ old('description', $banner->description) }}</textarea>
                            @error('description') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check"></i> Update Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .banner-edit-page {
            padding: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 14px;
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
            border-radius: 12px;
            border: 1px solid var(--border);
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
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .form {
            padding: 24px;
        }

        .form-section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            color: var(--text-dark);
        }

        .checkbox-label input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .text-muted {
            color: var(--text-muted);
            font-size: 13px;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            border-top: 1px solid var(--border);
            padding-top: 24px;
            margin-top: 24px;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
            justify-content: center;
        }

        .btn-lg {
            padding: 12px 20px;
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
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 768px) {
            .card-header {
                padding: 16px;
            }

            .form {
                padding: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .file-input-label {
                padding: 30px 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-lg {
                width: 100%;
            }
        }
    </style>

    <script>
        const fileInput = document.getElementById('bannerImage');
        const fileInputLabel = document.querySelector('.file-input-label');
        const imagePreview = document.getElementById('imagePreview');

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
    </script>
</x-admin-layout>
