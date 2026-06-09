<x-admin-layout>
    <x-slot:title>{{ $member->name }}</x-slot:title>

    <div class="member-detail-page">
        <div class="breadcrumb" style="margin-bottom: 20px;">
            <a href="{{ route('admin.members.index') }}">Members</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $member->name }}</span>
        </div>

        <div class="member-header">
            <div class="member-avatar-section">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $member->name }}" alt="Avatar" class="member-avatar">
                <div class="member-info">
                    <h1 class="member-name">{{ $member->name }}</h1>
                    <p class="member-role">{{ $member->role->name ?? 'Member' }}</p>
                    <div class="member-status">
                        @if ($member->memberStatus)
                            @if ($member->memberStatus->name === 'Active')
                                <span class="badge badge-success">{{ $member->memberStatus->name }}</span>
                            @else
                                <span class="badge badge-warning">{{ $member->memberStatus->name }}</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="member-actions">
                <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Member
                </a>
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="member-details-grid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>

                <div class="detail-list">
                    <div class="detail-item">
                        <label>Email</label>
                        <span>{{ $member->email }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Phone</label>
                        <span>{{ $member->phone ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Birthday</label>
                        <span>{{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('M d, Y') : '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Sex</label>
                        <span>{{ $member->sex ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Address</h3>
                </div>

                <div class="detail-list">
                    <div class="detail-item">
                        <label>Street</label>
                        <span>{{ $member->street ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>House No.</label>
                        <span>{{ $member->houseNo ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Barangay</label>
                        <span>{{ $member->barangay ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>City</label>
                        <span>{{ $member->city ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Church Information</h3>
                </div>

                <div class="detail-list">
                    <div class="detail-item">
                        <label>Member Type</label>
                        <span>{{ $member->member_type ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Baptism Status</label>
                        <span>{{ $member->baptism_status ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Baptism Date</label>
                        <span>{{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('M d, Y') : '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Ministry Interest</label>
                        <span>{{ $member->ministry_interest ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .member-detail-page {
            padding: 0;
        }

        .member-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding: 30px;
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .member-avatar-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .member-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .member-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .member-role {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0 0 8px 0;
        }

        .member-status {
            display: flex;
            gap: 8px;
        }

        .member-actions {
            display: flex;
            gap: 10px;
        }

        .member-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .detail-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 13px;
            text-transform: uppercase;
        }

        .detail-item span {
            color: var(--text-dark);
        }

        @media (max-width: 768px) {
            .member-header {
                flex-direction: column;
                gap: 20px;
            }

            .member-actions {
                width: 100%;
                flex-direction: column;
            }

            .member-actions .btn {
                width: 100%;
            }
        }
    </style>
</x-admin-layout>
