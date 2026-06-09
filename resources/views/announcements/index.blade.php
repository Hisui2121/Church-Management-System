<x-member-layout>
    <x-slot:title>Announcements</x-slot:title>

    <div class="announcements-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Announcements</h1>
                <p class="page-subtitle">Stay updated with the latest news from our church</p>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="announcements-grid">
            @forelse ($announcements as $announcement)
            <div class="announcement-card">
                @if ($announcement->image_path)
                <div class="announcement-image">
                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}">
                </div>
                @endif
                <div class="announcement-content">
                    <h3 class="announcement-title">{{ $announcement->title }}</h3>
                    <div class="announcement-meta">
                        <span class="announcement-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="announcement-body">
                        {!! Str::limit(strip_tags($announcement->body), 150) !!}
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-megaphone-fill"></i>
                <h3>No Announcements</h3>
                <p>There are currently no announcements available.</p>
            </div>
            @endforelse
        </div>

        @if ($announcements->hasPages())
        <div class="pagination-wrapper">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>

    <style>
        .announcements-page {
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
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .announcement-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .announcement-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .announcement-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .announcement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .announcement-content {
            padding: 20px;
        }

        .announcement-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 8px 0;
            line-height: 1.4;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .announcement-date {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .announcement-body {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
            margin: 0;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .announcements-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
            }

            .page-header h1 {
                font-size: 24px;
            }
        }
    </style>
</x-member-layout>
