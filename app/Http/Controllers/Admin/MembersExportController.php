<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MembersExportController extends Controller
{
    public function export()
    {
        $filename = 'members_export_' . now()->format('Ymd_His') . '.csv';
        $members = User::with(['memberStatus', 'roles', 'member.ministries'])->get();

        $callback = function () use ($members) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID','Name','Email','Phone','Roles','Ministries','Status','Joined']);

            foreach ($members as $m) {
                $roles = $m->roles->pluck('name')->join('|');
                $ministries = $m->member?->ministries?->pluck('name')?->join('|');
                fputcsv($handle, [
                    $m->id,
                    $m->name,
                    $m->email,
                    $m->phone,
                    $roles,
                    $ministries,
                    $m->memberStatus?->name,
                    $m->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function report()
    {
        $filename = 'members_report_' . now()->format('Ymd_His') . '.csv';

        $total = User::count();
        $byStatus = User::with('memberStatus')->get()->groupBy(fn($u) => $u->memberStatus?->name ?? 'No Status')->map->count();

        $callback = function() use ($total, $byStatus) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Metric','Value']);
            fputcsv($handle, ['Total Members', $total]);
            fputcsv($handle, []);
            fputcsv($handle, ['Status','Count']);
            foreach ($byStatus as $status => $count) {
                fputcsv($handle, [$status, $count]);
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, ['Content-Type' => 'text/csv']);
    }
}
