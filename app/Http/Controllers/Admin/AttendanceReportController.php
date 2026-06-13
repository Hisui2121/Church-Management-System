<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $attendances = Attendance::with('member', 'serviceSession')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Summary stats
        $totalRecords = Attendance::whereBetween('date', [$startDate, $endDate])->count();
        $presentCount = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('is_present', true)
            ->count();
        $absentCount = $totalRecords - $presentCount;
        
        // Count guests vs members
        $guestCount = Attendance::whereBetween('date', [$startDate, $endDate])
            ->whereHas('member.memberType', function($q) {
                $q->whereRaw("LOWER(name) LIKE '%guest%' OR LOWER(name) LIKE '%visitor%'");
            })
            ->count();

        // Get list of months and years for dropdown
        $months = collect(range(1, 12))->map(function($m) {
            return [
                'value' => $m,
                'label' => Carbon::createFromDate(2024, $m, 1)->format('F')
            ];
        });

        $currentYear = now()->year;
        $years = collect(range($currentYear - 5, $currentYear + 1));

        return view('admin.attendance.reports', compact(
            'attendances',
            'month',
            'year',
            'months',
            'years',
            'totalRecords',
            'presentCount',
            'absentCount',
            'guestCount',
            'startDate',
            'endDate'
        ));
    }

    public function exportCSV(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $attendances = Attendance::with('member', 'serviceSession')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // Create CSV content
        $filename = 'attendance-report-' . $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename"
        );

        $columns = array('Date', 'Member Name', 'Member Type', 'Status', 'Service');

        $callback = function() use ($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                fputcsv($file, array(
                    $attendance->date->format('M d, Y'),
                    $attendance->member->full_name ?? 'N/A',
                    $attendance->member->memberType->name ?? 'N/A',
                    $attendance->is_present ? 'Present' : 'Absent',
                    $attendance->serviceSession->service_title ?? 'Regular Service',
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        // Reuse CSV generation but set Excel-friendly headers
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $attendances = Attendance::with('member', 'serviceSession')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $filename = 'attendance-report-' . $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv';
        $headers = array(
            "Content-type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$filename"
        );

        $columns = array('Date', 'Member Name', 'Member Type', 'Status', 'Service');

        $callback = function() use ($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                fputcsv($file, array(
                    $attendance->date->format('M d, Y'),
                    $attendance->member->full_name ?? 'N/A',
                    $attendance->member->memberType->name ?? 'N/A',
                    $attendance->is_present ? 'Present' : 'Absent',
                    $attendance->serviceSession->service_title ?? 'Regular Service',
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $attendances = Attendance::with('member', 'serviceSession')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // If barryvdh/laravel-dompdf is installed, use it. Otherwise, return an HTML fallback.
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf') || class_exists('\Dompdf\Dompdf')) {
            try {
                $pdf = app()->make(\Barryvdh\DomPDF\Facade\Pdf::class ?? \Dompdf\Dompdf::class);
            } catch (\Throwable $e) {
                $pdf = null;
            }
        } else {
            $pdf = null;
        }

        if ($pdf) {
            $html = view('admin.attendance.reports-pdf', compact('attendances', 'startDate', 'endDate'))->render();
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="attendance-' . $year . '-' . $month . '.pdf"'
            ]);
        }

        // Fallback: render a printable HTML file the admin can save as PDF from browser
        $htmlView = view('admin.attendance.reports-pdf-fallback', compact('attendances', 'startDate', 'endDate'))->render();
        return response($htmlView, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="attendance-' . $year . '-' . $month . '.html"'
        ]);
    }
}
