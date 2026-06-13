<x-admin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="admin-dashboard-container">
        {{-- STAT CARDS ROW --}}
        <div class="dashboard-stats">
            {{-- TOTAL MEMBERS --}}
            <div class="stat-card-heroes">
                <div class="stat-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-title">Total Members</div>
                    <div class="stat-card-value">{{ $totalMembers }} heroes members</div>
                </div>
            </div>

            {{-- TOTAL MINISTRIES --}}
            <div class="stat-card-heroes">
                <div class="stat-card-icon">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-title">Total Ministries</div>
                    <div class="stat-card-value">{{ $totalMinistries }} heroes ministry</div>
                </div>
            </div>

            {{-- ACTIVE ANNOUNCEMENTS --}}
            <div class="stat-card-heroes">
                <div class="stat-card-icon">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-title">Active Announcements</div>
                    <div class="stat-card-value">{{ $activeAnnouncements }} heroes announcements</div>
                </div>
            </div>

            {{-- ATTENDANCE --}}
            <div class="stat-card-heroes">
                <div class="stat-card-icon">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-title">Attendance</div>
                    <div class="stat-card-value">{{ $totalAttendance }} attendance records</div>
                </div>
            </div>

            {{-- GENERATE REPORT BUTTON --}}
            <div class="stat-card-button">
                <a href="{{ route('admin.members.report') }}" class="btn-generate-report">
                    <i class="bi bi-download"></i> Generate Report
                </a>
            </div>
        </div>

        {{-- MAIN CONTENT GRID --}}
        <div class="dashboard-content-grid">
            {{-- LEFT SECTION - MEMBERS TABLE --}}
            <div class="dashboard-left-section">
                {{-- HEROES' MEMBERS SECTION --}}
                <div class="card card-heroes">
                    <div class="card-header-heroes">
                        <div>
                            <h3 class="card-title-heroes">Heroes' Members</h3>
                            <p class="card-subtitle-heroes">Track and organize all members of heroes</p>
                        </div>
                        <div class="card-header-actions">
                            <a href="{{ route('admin.members.index') }}" class="link-view-all">View all</a>
                            <a href="{{ route('admin.members.export') }}" class="btn-export">
                                <i class="bi bi-download"></i> Export
                            </a>
                        </div>
                    </div>

                    <div class="table-wrapper-heroes">
                        <table class="table-heroes">
                            <thead>
                                <tr>
                                    <th>STATUS</th>
                                    <th>NAME</th>
                                    <th>ROLES</th>
                                    <th>MINISTRY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($heroesMembers as $member)
                                <tr>
                                    <td>
                                        @php
                                            $statusName = $member->memberStatus?->name ?? 'No Status';
                                            $statusClass = match($statusName) {
                                                'Active' => 'active',
                                                'Inactive' => 'inactive',
                                                'Visitor' => 'visitor',
                                                default => 'pending'
                                            };
                                        @endphp
                                        <div class="table-cell-status">
                                            <span class="status-dot {{ $statusClass }}"></span>
                                            {{ $statusName }}
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $member->name }}</span>
                                    </td>
                                    <td>
                                        @forelse ($member->roles as $role)
                                            <span class="role-badge">{{ $role->name }}</span>
                                        @empty
                                            <span class="role-badge">No Role</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <span class="ministry-text">{{ $member->ministryNames() }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 30px; color: #999;">
                                        No members yet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT SECTION - SIDEBAR --}}
            <div class="dashboard-right-section">
                {{-- ANNOUNCEMENTS SECTION --}}
                <div class="card card-sidebar">
                    <div class="sidebar-header">
                        <div>
                            <h3>Announcements</h3>
                            <p class="sidebar-subtitle">Browse and manage all active announcements</p>
                        </div>
                        <a href="{{ route('admin.announcements.index') }}" class="link-view-all">View all</a>
                    </div>

                    <div class="sidebar-content">
                        @forelse ($announcements as $announcement)
                        <div class="announcement-item">
                            <div class="announcement-title">{{ $announcement->title ?? 'No Title' }}</div>
                            <div class="announcement-desc">{{ Str::limit($announcement->body, 100) ?? 'No content' }}</div>
                        </div>
                        @empty
                        <div class="sidebar-empty">
                            <div class="empty-icon">📢</div>
                            <p>No announcements yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- ACTIVITY LOG SECTION --}}
                <div class="card card-sidebar mt-4">
                    <div class="sidebar-header">
                        <h3>Activity Log</h3>
                        <a href="{{ route('audit_logs.index') }}" class="link-view-all">view all</a>
                    </div>

                    <div class="sidebar-content">
                        @forelse ($activityLog as $log)
                        <div class="activity-item">
                            <div class="activity-action">{{ $log->action ?? 'System Action' }}</div>
                            <div class="activity-time">{{ $log->created_at?->diffForHumans() ?? 'Recently' }}</div>
                        </div>
                        @empty
                        <div class="sidebar-empty">
                            <p>No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .admin-dashboard-container {
            padding: 0;
        }

        /* STAT CARDS */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 30px;
        }

        .stat-card-heroes {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            min-height: 118px;
            padding: 18px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s ease;
        }

        .stat-card-heroes:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .stat-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            flex-shrink: 0;
        }

        .stat-card-content {
            flex: 1;
        }

        .stat-card-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-card-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .stat-card-button {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            min-height: 118px;
            padding: 18px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-generate-report {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-generate-report:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(103, 182, 158, 0.3);
        }

        /* MAIN CONTENT GRID */
        .dashboard-content-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
            align-items: stretch;
        }

        .dashboard-left-section {
            flex: 1;
        }

        .dashboard-right-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* CARD STYLES */
        .card-heroes {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            min-height: 100%;
        }

        .card-header-heroes {
            padding: 24px 30px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .card-title-heroes {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .card-subtitle-heroes {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .card-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .link-view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .link-view-all:hover {
            color: var(--primary-dark);
        }

        .btn-export {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            background: var(--primary-dark);
        }

        /* TABLE STYLES */
        .table-wrapper-heroes {
            overflow-x: auto;
            padding: 0 24px 24px;
        }

        .table-heroes {
            width: 100%;
            border-collapse: collapse;
        }

        .table-heroes thead tr {
            background: var(--bg-light);
            border-bottom: 1px solid var(--border);
        }

        .table-heroes thead th {
            padding: 16px 30px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-heroes tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.2s ease;
        }

        .table-heroes tbody tr:hover {
            background: var(--bg-light);
        }

        .table-heroes tbody td {
            padding: 18px 30px;
            font-size: 14px;
            color: var(--text-dark);
        }

        .table-cell-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
        }

        .status-dot.active {
            background: #10b981;
        }

        .status-dot.inactive {
            background: #ef4444;
        }

        .status-dot.visitor {
            background: #60a5fa;
        }

        .status-dot.pending {
            background: #f6ad55;
        }

        .table-cell-member {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .role-badge {
            background: var(--bg-light);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .ministry-text {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* SIDEBAR CARDS */
        .card-sidebar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .sidebar-header > div {
            flex: 1;
            min-width: 0;
        }

        .sidebar-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 11px;
            color: #999;
            margin: 0;
            line-height: 1.25;
        }

        .sidebar-content {
            padding: 16px 24px;
            max-height: 300px;
            overflow-y: auto;
        }

        .announcement-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .announcement-item:last-child {
            border-bottom: none;
        }

        .announcement-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .announcement-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .activity-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-action {
            font-size: 12px;
            color: var(--text-dark);
            font-weight: 500;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-muted);
        }

        .sidebar-empty {
            padding: 30px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 12px;
        }

        .empty-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .dashboard-content-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card-button {
                grid-column: auto;
            }
        }

        @media (max-width: 768px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .card-header-heroes {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-header-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .table-heroes thead th,
            .table-heroes tbody td {
                padding: 12px 16px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .stat-card-heroes {
                flex-direction: column;
                text-align: center;
            }

            .stat-card-button {
                padding: 16px;
            }

            .btn-generate-report {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</x-admin-layout>
