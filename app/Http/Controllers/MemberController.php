<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\AuditLog;

class MemberController extends Controller
{
    /**
     * Display all members
     */
    public function index()
    {
        $members = Member::latest()->paginate(10);

        return view('member.index', compact('members'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Store member
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',

            'birthdate'         => 'nullable|date',

            'gender'            => 'nullable',

            'contact_number'    => 'nullable|max:255',

            'email'             => 'nullable|email',

            'address'           => 'nullable',

            'member_status'     => 'required',

            'member_type'       => 'required',

            'date_joined'       => 'nullable|date',
        ]);

        $member = Member::create($validated);

        AuditLog::record(
            action:         'created',
            tableName:      'members',
            recordId:       $member->id,
            description:    "Created member: {$member->first_name} {$member->last_name}"
        );

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    /**
     * Show single member
     */
    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }

    /**
     * Edit form
     */
    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    /**
     * Update member
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([

            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',

            'birthdate'         => 'nullable|date',

            'gender'            => 'nullable',

            'contact_number'    => 'nullable|max:255',

            'email'             => 'nullable|email',

            'address'           => 'nullable',

            'member_status'     => 'required',

            'member_type'       => 'required',

            'date_joined'       => 'nullable|date',
        ]);

        $member->update($validated);

        AuditLog::record(
            action:         'updated',
            tableName:      'members',
            recordId:       $member->id,
            description:    "Updated member: {$member->first_name} {$member->last_name}"
        );

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Delete member
     */
    public function destroy(Member $member)
    {
        $fullName = "{$member->first_name} {$member->last_name}";
        $memberId = $member->id;
        $member->delete();

        AuditLog::record(
            action:       'deleted',
            tableName:    'members',
            recordId:     $memberId,
            description:  "Deleted member: {$fullName}"
        );

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}