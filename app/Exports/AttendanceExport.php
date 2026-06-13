<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\Spreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithStyles
{
    protected $attendances;
    protected $month;
    protected $year;

    public function __construct($attendances, $month, $year)
    {
        $this->attendances = $attendances;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return $this->attendances->map(function($attendance) {
            return [
                'Date' => $attendance->date->format('M d, Y'),
                'Member Name' => $attendance->member->full_name ?? 'N/A',
                'Member Type' => $attendance->member->memberType->name ?? 'N/A',
                'Status' => $attendance->is_present ? 'Present' : 'Absent',
                'Service' => $attendance->serviceSession->service_title ?? 'Regular Service',
                'Recorded By' => $attendance->recordedBy->name ?? 'Auto',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date',
            'Member Name',
            'Member Type',
            'Status',
            'Service',
            'Recorded By',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F46E5']],
            ],
        ];
    }
}
