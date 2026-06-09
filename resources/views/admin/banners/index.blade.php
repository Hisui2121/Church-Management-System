<x-admin-layout>
    <x-slot:title>Banners</x-slot:title>

    <div class="banners-page">
        <div class="page-header">
            <div>
                <h1>Banners</h1>
                <p>Manage carousel banners displayed on the member dashboard</p>
            </div>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Banner
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>All Banners</h3>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $banner)
                        <tr>
                            <td>
                                @if ($banner->image_path)
                                <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="table-image">
                                @else
                                <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <span class="font-weight-600">{{ $banner->title ?? 'Untitled' }}</span>
                                @if ($banner->description)
                                <div class="text-muted small">{{ Str::limit($banner->description, 50) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $banner->order }}</span>
                            </td>
                            <td>
                                @if ($banner->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $banner->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn-icon" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No banners yet. <a href="{{ route('admin.banners.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($banners->hasPages())
            <div class="pagination-wrapper">
                {{ $banners->links() }}
            </div>
            @endif
        </div>
    </div>

    <style>
        .banners-page {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 16px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .page-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f9fafb;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 16px;
            border-top: 1px solid var(--border);
        }

        .table-image {
            width: 80px;
            height: 45px;
            object-fit: cover;
            border-radius: 6px;
        }

        .font-weight-600 {
            font-weight: 600;
        }

        .text-muted {
            color: var(--text-muted);
        }

        .text-muted.small {
            font-size: 12px;
            margin-top: 4px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-icon.btn-danger:hover {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .inline {
            display: contents;
        }

        .pagination-wrapper {
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
            }

            .data-table {
                font-size: 14px;
            }

            .data-table th,
            .data-table td {
                padding: 12px 8px;
            }

            .table-image {
                width: 60px;
                height: 34px;
            }
        }
    </style>
</x-admin-layout>
