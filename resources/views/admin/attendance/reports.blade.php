<x-admin-layout>
    <x-slot:title>Attendance Reports</x-slot:title>

    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Attendance Reports</h1>
                <p class="page-subtitle">View and export attendance records by month</p>
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="filters-card">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label class="filter-label">Month</label>
                    <select name="month" class="filter-input">
                        @foreach($months as $m)
                            <option value="{{ $m['value'] }}" {{ $month == $m['value'] ? 'selected' : '' }}>
                                {{ $m['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Year</label>
                    <select name="year" class="filter-input">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
            </form>

            <div class="export-buttons">
                <form action="{{ route('admin.attendance.reports.export-pdf') }}" method="GET" style="display: inline;">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <button type="submit" class="btn btn-export-pdf">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </button>
                </form>
                <form action="{{ route('admin.attendance.reports.export-excel') }}" method="GET" style="display: inline;">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <button type="submit" class="btn btn-export-excel">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export Excel
                    </button>
                </form>
            </div>
        </div>

        {{-- SUMMARY STATS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon members">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Members</div>
                    <div class="stat-value">{{ $totalRecords }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon present">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Present</div>
                    <div class="stat-value">{{ $presentCount }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon absent">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Absent</div>
                    <div class="stat-value">{{ $absentCount }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon guests">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Guests</div>
                    <div class="stat-value">{{ $guestCount }}</div>
                </div>
            </div>
        </div>

        {{-- ATTENDANCE TABLE --}}
        @if($attendances->count() > 0)
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Attendance Records</h3>
                <small class="record-count">{{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</small>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Member Name</th>
                            <th>Member Type</th>
                            <th>Status</th>
                            <th>Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                            <td>
                                <div class="member-info">
                                    <span class="member-name">{{ $attendance->member->full_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-member-type">
                                    {{ $attendance->member->memberType->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $attendance->is_present ? 'badge-present' : 'badge-absent' }}">
                                    {{ $attendance->is_present ? 'Present' : 'Absent' }}
                                </span>
                            </td>
                            <td>
                                <small class="service-info">
                                    {{ $attendance->serviceSession->service_title ?? 'Regular Service' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
            <div class="table-pagination">
                {{ $attendances->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
            <div class="empty-state-title">No Attendance Records</div>
            <div class="empty-state-text">No attendance records found for {{ Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</div>
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

        .filters-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .filter-form {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            background: white;
            color: var(--text-dark);
            min-width: 120px;
        }

        .btn-filter {
            padding: 8px 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
        }

        .export-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-export-pdf,
        .btn-export-excel {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-export-pdf {
            background: #ef4444;
            color: white;
        }

        .btn-export-pdf:hover {
            background: #dc2626;
        }

        .btn-export-excel {
            background: #10b981;
            color: white;
        }

        .btn-export-excel:hover {
            background: #059669;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-icon.members {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.present {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .stat-icon.absent {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .stat-icon.guests {
            background: rgba(251, 191, 36, 0.15);
            color: #f59e0b;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .table-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }

        .table-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .record-count {
            font-size: 12px;
            color: var(--text-muted);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f9fafb;
            border-bottom: 1px solid var(--border);
        }

        .data-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
            color: var(--text-dark);
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .member-name {
            font-weight: 500;
            color: var(--text-dark);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-member-type {
            background: var(--primary-light);
            color: var(--primary);
        }

        .badge-present {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .badge-absent {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .service-info {
            color: var(--text-muted);
            font-size: 12px;
        }

        .table-pagination {
            padding: 16px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
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

        @media (max-width: 768px) {
            .filters-card {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-form {
                width: 100%;
            }

            .export-buttons {
                width: 100%;
            }

            .export-buttons button {
                flex: 1;
            }

            .data-table {
                font-size: 12px;
            }

            .data-table td {
                padding: 10px 8px;
            }
        }
    </style>
</x-admin-layout>
