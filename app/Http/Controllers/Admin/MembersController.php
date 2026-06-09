<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(): View
    {
        $members = \App\Models\User::with('memberStatus')->paginate(15);
        return view('admin.members.index', [
            'title' => 'Members',
            'members' => $members,
        ]);
    }

    public function create(): View
    {
        return view('admin.members.create', [
            'title' => 'Add Member',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|string',
            'street' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city' => 'nullable|string',
            'member_status' => 'nullable|string',
            'member_type' => 'nullable|string',
            'baptism_status' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'ministry_interest' => 'nullable|string',
        ]);

        if ($validated['member_status'] ?? null) {
            $status = \App\Models\MemberStatus::where('name', $validated['member_status'])->first();
            $validated['member_status_id'] = $status?->id;
            unset($validated['member_status']);
        }

        $member = \App\Models\User::create($validated);
        return redirect()->route('admin.members.show', $member->id)->with('success', 'Member created successfully');
    }

    public function show($id): View
    {
        $member = \App\Models\User::findOrFail($id);
        return view('admin.members.show', [
            'title' => 'Member Details',
            'member' => $member,
        ]);
    }

    public function edit($id): View
    {
        $member = \App\Models\User::findOrFail($id);
        return view('admin.members.edit', [
            'title' => 'Edit Member',
            'member' => $member,
        ]);
    }

    public function update(Request $request, $id)
    {
        $member = \App\Models\User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|string',
            'street' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city' => 'nullable|string',
            'member_status' => 'nullable|string',
            'member_type' => 'nullable|string',
            'baptism_status' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'ministry_interest' => 'nullable|string',
        ]);

        if ($validated['member_status'] ?? null) {
            $status = \App\Models\MemberStatus::where('name', $validated['member_status'])->first();
            $validated['member_status_id'] = $status?->id;
            unset($validated['member_status']);
        }

        $member->update($validated);
        return redirect()->route('admin.members.show', $id)->with('success', 'Member updated successfully');
    }

    public function destroy($id)
    {
        $member = \App\Models\User::findOrFail($id);
        $memberName = $member->name;
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', "Member \"$memberName\" deleted successfully");
    }
}
