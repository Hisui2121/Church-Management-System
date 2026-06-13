<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Attendance Management</h2>
            @if($activeSession)
                <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Record Attendance
                </a>
            @else
                <span class="text-sm text-gray-500">Start a service session to record attendance.</span>
            @endif
        </div>

    {{-- START SERVICE SESSION CARD --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="bi bi-play-circle"></i> Start a New Service Session
        </h3>

        @if($activeSession)
            <div class="bg-green-50 border border-green-200 rounded p-4">
                <p class="text-green-800 font-semibold">✓ Active Session: <strong>{{ $activeSession->service_title ?? 'Service' }}</strong></p>
                <p class="text-green-700 text-sm">Started: {{ $activeSession->started_at?->format('M d, Y h:i A') ?? 'N/A' }}</p>
                <form action="{{ route('admin.session.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">End Service Session</button>
                </form>
            </div>
        @else
            <div class="bg-white rounded-lg border p-4">
                <p class="text-sm text-gray-600">No Active Service Session</p>
                <div class="mt-3">
                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700" onclick="openServiceSessionModal()">
                        <i class="bi bi-plus-circle"></i> Start Service Session
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Attendance</h3>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
                <form method="GET" action="{{ route('admin.attendance.index') }}" class="flex flex-col md:flex-row items-start md:items-center gap-2">
                    <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white cursor-pointer">
                        @foreach($months as $m)
                            <option value="{{ $m['value'] }}" {{ $month == $m['value'] ? 'selected' : '' }}>{{ $m['label'] }}</option>
                        @endforeach
                    </select>
                    <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white cursor-pointer">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-2 bg-[#f3f4f6] border rounded text-sm text-gray-700 hover:bg-gray-100">Filter</button>
                </form>

                <a href="{{ route('admin.attendance.reports.export-excel', ['month' => $month, 'year' => $year]) }}" class="px-3 py-2 border rounded text-sm hover:bg-gray-100">Export Excel</a>
                <a href="{{ route('admin.attendance.reports.export-pdf', ['month' => $month, 'year' => $year]) }}" class="px-3 py-2 border rounded text-sm hover:bg-gray-100">Export PDF</a>
        </div>

        @if($attendances->count())
            <div class="attendance-cards mt-6 space-y-4">
                @foreach($attendances as $a)
                    @php
                        $attendeeName = $a->member?->full_name ?? $a->user?->name ?? 'Guest';
                        $attendeeRole = $a->member ? 'Member' : 'Guest';
                        $attendanceStatus = $a->is_present ? 'Present' : 'Absent';
                    @endphp
                    <div class="attendance-card">
                        <div class="attendance-card-top">
                            <div>
                                <p class="attendance-label">Name</p>
                                <div class="attendance-value">{{ $attendeeName }}</div>
                            </div>
                            <div>
                                <p class="attendance-label">Role</p>
                                <div class="attendance-value">{{ $attendeeRole }}</div>
                            </div>
                            <div>
                                <p class="attendance-label">Check-in</p>
                                <div class="attendance-value">{{ $a->checked_in_at?->format('h:i A') ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="attendance-card-meta">
                            <div>
                                <p class="attendance-label">Service</p>
                                <div class="attendance-value">{{ $a->serviceSession?->service_title ?? $a->service?->name ?? 'Regular Service' }}</div>
                            </div>
                            <div>
                                <p class="attendance-label">Status</p>
                                <span class="badge-status {{ $a->is_present ? 'present' : 'absent' }}">{{ $attendanceStatus }}</span>
                            </div>
                            <div>
                                <p class="attendance-label">Date</p>
                                <div class="attendance-value">{{ $a->date?->format('M d, Y') ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                <div class="empty-state-title">No attendance records found</div>
                <div class="empty-state-text">No attendance records were found for the selected period.</div>
            </div>
        @endif

        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>

    <style>
        .attendance-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .attendance-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .attendance-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #d1d5db;
        }

        /* Top row - 3 columns: Name, Role, Check-in */
        .attendance-card-top {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1.5fr;
            gap: 24px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* Bottom row - 3 columns: Service, Status, Date */
        .attendance-card-meta {
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr;
            gap: 24px;
            align-items: center;
        }

        /* Individual field styling */
        .attendance-card > div > div {
            display: flex;
            flex-direction: column;
        }

        .attendance-label {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
            display: block;
        }

        .attendance-value {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.4;
            word-break: break-word;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            width: fit-content;
        }

        .badge-status.present {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status.absent {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .attendance-card-top,
            .attendance-card-meta {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .attendance-card-top > div:nth-child(3) {
                grid-column: 1 / -1;
            }

            .attendance-card-meta > div:nth-child(2) {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 640px) {
            .attendance-card {
                padding: 16px;
            }

            .attendance-card-top,
            .attendance-card-meta {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 16px;
            }

            .attendance-card-top {
                padding-bottom: 16px;
            }

            .attendance-label {
                font-size: 9px;
                margin-bottom: 6px;
            }

            .attendance-value {
                font-size: 14px;
            }
        }
    </style>

@include('admin.partials.service-session-modal')

</x-admin-layout>
