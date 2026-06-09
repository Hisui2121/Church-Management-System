<x-admin-layout>
    <x-slot:title>Messages</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Messages</h1>
                <p class="page-subtitle">Communication center for church members</p>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Message
            </button>
        </div>

        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-chat-dots-fill"></i></div>
            <div class="empty-state-title">No Messages</div>
            <div class="empty-state-text">Start messaging to connect with church members</div>
            <button class="btn btn-primary">Send Message</button>
        </div>
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
    </style>
</x-admin-layout>
