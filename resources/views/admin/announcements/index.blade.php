<x-admin-layout>
    <x-slot:title>Announcements</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Announcements</h1>
                <p class="page-subtitle">Create and manage church announcements</p>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Announcement
            </a>
        </div>

        @if ($announcements->count() > 0)
        <div class="announcements-list">
            @foreach ($announcements as $announcement)
            <div class="announcement-item-card" role="button" tabindex="0" data-title="{{ $announcement->title }}" data-body="{{ addslashes($announcement->body) }}" onclick="openAnnouncementPreview(this)">
                <div class="announcement-header">
                    <div>
                        <h3 class="announcement-title">{{ $announcement->title }}</h3>
                        <div class="announcement-meta">
                            <span class="meta-item">By {{ $announcement->creator->name ?? 'Admin' }}</span>
                            <span class="meta-separator">•</span>
                            <span class="meta-item">{{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="announcement-actions">
                        <span class="status-badge {{ $announcement->is_active ? 'active' : 'inactive' }}">
                            {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="action-btn" title="Edit" onclick="event.stopPropagation()"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Delete" onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this announcement?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                <p class="announcement-body">{{ Str::limit($announcement->body, 200) ?? 'No content' }}</p>
            </div>
            @endforeach
        </div>

        @if ($announcements->hasPages())
        <div class="pagination-wrapper">
            {{ $announcements->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-megaphone-fill"></i></div>
            <div class="empty-state-title">No Announcements</div>
            <div class="empty-state-text">Share important updates and news with your church community</div>
            <button class="btn btn-primary">Create Announcement</button>
        </div>
        @endif
    </div>

    <style>
        .admin-page {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .announcements-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 30px;
        }

        .announcement-item-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
        }

        .announcement-item-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
            gap: 20px;
        }

        .announcement-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .announcement-meta {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-item {
            white-space: nowrap;
        }

        .meta-separator {
            opacity: 0.5;
        }

        .announcement-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-badge.inactive {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: #ef4444;
        }

        .announcement-body {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 64px;
            color: var(--primary-light);
            margin-bottom: 16px;
        }

        .empty-state-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state-text {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .announcement-header {
                flex-direction: column;
            }

            .announcement-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>

    <!-- Announcement preview modal -->
    <div id="announcementPreviewModal" class="preview-modal" style="display:none">
        <div class="preview-modal-backdrop" onclick="closeAnnouncementPreview()"></div>
        <div class="preview-modal-content" role="dialog" aria-modal="true">
            <div class="preview-modal-header">
                <h3 id="announcement-preview-title"></h3>
                <button class="btn-close" onclick="closeAnnouncementPreview()">&times;</button>
            </div>
            <div id="announcement-preview-body" class="preview-modal-body"></div>
        </div>
    </div>

    <style>
        .preview-modal { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 2000; }
        .preview-modal-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.4); }
        .preview-modal-content { position: relative; background: white; border-radius: 8px; max-width: 800px; width: 90%; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); z-index: 2; }
        .preview-modal-header { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px }
        .preview-modal-body { color: var(--text-dark); }
        .btn-close { background: transparent; border: none; font-size: 24px; cursor: pointer }
    </style>

    <script>
        function openAnnouncementPreview(el) {
            var title = el.dataset.title || '';
            var body = el.dataset.body || '';
            document.getElementById('announcement-preview-title').textContent = title;
            document.getElementById('announcement-preview-body').innerHTML = body || '<em>No content</em>';
            document.getElementById('announcementPreviewModal').style.display = 'flex';
        }
        function closeAnnouncementPreview(){ document.getElementById('announcementPreviewModal').style.display = 'none'; }
    </script>
</x-admin-layout>
