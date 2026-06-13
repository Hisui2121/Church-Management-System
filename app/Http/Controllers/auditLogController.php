<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuditLogIndexRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuditLogController extends Controller
{
    // Display audit log list

    public function index(AuditLogIndexRequest $request) 
    {
        $filters = $request->validated();

        $query = AuditLog::with('user')->latest();

        //Filters by actions
        if (!empty($filters['action'])) {
            $actionFilters = array_map(fn($action) => Str::lower($action), (array) $filters['action']);
            $query->whereIn(DB::raw('LOWER(action)'), $actionFilters);
        }

        //Filters by page
        if (!empty($filters['page'])) {
            $query->whereIn('page', $filters['page']);
        }

        // Search 
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search){
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $actions = AuditLog::selectRaw('LOWER(action) as action_key')
            ->distinct()
            ->pluck('action_key')
            ->map(fn($action) => Str::title($action))
            ->merge(['Created', 'Deleted'])
            ->unique()
            ->sort()
            ->values();

        $pages = AuditLog::distinct()
            ->orderBy('page')
            ->pluck('page')
            ->filter()
            ->map(fn($page) => trim($page))
            ->unique()
            ->values();

        return view('audit_log.index', compact('logs', 'actions', 'pages', 'filters'));
    }

    //Show single log entry
    public function show(AuditLog $auditLog) {
        if (!auth()->user()->hasPermission('view_audit_logs')) {
            abort(403);
        }

        return view('audit_log.show', compact('auditLog'));
    }

    // Clear all audit logs
    public function clear() {
        if (!auth()->user()->hasPermission('view_audit_logs')) {
            abort(403);
        }

        AuditLog::truncate();
        return redirect()->route('audit_logs.index')->with('success', 'All audit logs have been cleared');
    }
}
