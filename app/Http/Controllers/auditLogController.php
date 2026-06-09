<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    // Display audit log list

    public function index(Request $request) {
        $query = AuditLog::with('user')->latest();

        //Filters by actions
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        //Filters by table
        if ($request->filled('table_name')) {
            $query->where('table_name', $request->table_name);
        }

        // Search 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search){
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $actions    = AuditLog::distinct()->pluck('action');
        $tableNames = AuditLog::distinct()->pluck('table_name');

        return view('audit_log.index', compact('logs', 'actions', 'tableNames'));
    }

    //Show single log entry
    public function show(AuditLog $auditLog) {
        return view('audit_log.show', compact('auditLog'));
    }

    // Clear all audit logs
    public function clear() {
        AuditLog::truncate();
        return redirect()->route('audit_logs.index')->with('success', 'All audit logs have been cleared');
    }
}
