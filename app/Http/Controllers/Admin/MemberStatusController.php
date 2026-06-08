<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberStatus;
use Illuminate\Http\Request;

class MemberStatusController extends Controller
{
    public function __construct()
    {
        // Only admins can access this controller
    }

    public function index()
    {
        $statuses       = MemberStatus::all();
        $available      = MemberStatus::availablePermissions();

        return view('admin.member-statuses.index', compact('statuses', 'available'));
    }

    public function edit(MemberStatus $memberStatus)
    {
        $this->authorize('update', $memberStatus);
        $available = MemberStatus::availablePermissions();
        return view('admin.member-statuses.edit', compact('memberStatus', 'available'));
    }

    public function update(Request $request, MemberStatus $memberStatus)
    {
        $this->authorize('update', $memberStatus);

        $memberStatus->update([
            'permissions' => $request->input('permissions', []),
        ]);

        return redirect()
            ->route('admin.member-statuses.index')
            ->with('success', "Permissions for \"{$memberStatus->name}\" updated.");
    }
}