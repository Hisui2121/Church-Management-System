<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; }
        .header { text-align: center; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 13px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Attendance Report</h2>
        <div>{{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Type</th>
                <th>Status</th>
                <th>Service</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $a)
                <tr>
                    <td>{{ $a->date->format('M d, Y') }}</td>
                    <td>{{ $a->member->full_name ?? 'N/A' }}</td>
                    <td>{{ $a->member->memberType->name ?? 'N/A' }}</td>
                    <td>{{ $a->is_present ? 'Present' : 'Absent' }}</td>
                    <td>{{ $a->serviceSession->service_title ?? 'Service' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // When opened, trigger print so admin can save as PDF
        window.onload = function() { window.print(); };
    </script>
</body>
</html>