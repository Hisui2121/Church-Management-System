<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

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

            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',

            'birthdate' => 'nullable|date',

            'gender' => 'nullable',

            'contact_number' => 'nullable|max:255',

            'email' => 'nullable|email',

            'address' => 'nullable',

            'member_status' => 'required',

            'member_type' => 'required',

            'date_joined' => 'nullable|date',
        ]);

        Member::create($validated);

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

            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',

            'birthdate' => 'nullable|date',

            'gender' => 'nullable',

            'contact_number' => 'nullable|max:255',

            'email' => 'nullable|email',

            'address' => 'nullable',

            'member_status' => 'required',

            'member_type' => 'required',

            'date_joined' => 'nullable|date',
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Delete member
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}