<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MinistriesController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->hasPermission('view_ministries')) {
            abort(403, 'You do not have permission to view ministries.');
        }
        $ministries = Ministry::latest()->paginate(15);
        
        return view('admin.ministries.index', [
            'title' => 'Ministries',
            'ministries' => $ministries,
        ]);
    }

    public function create(): View
    {
        return view('admin.ministries.create', [
            'title' => 'Add Ministry',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:ministries',
            'description' => 'nullable|string',
        ]);

        Ministry::create($validated);
        return redirect()->route('admin.ministries.index')->with('success', 'Ministry created successfully');
    }

    public function edit(Ministry $ministry): View
    {
        return view('admin.ministries.edit', [
            'title' => 'Edit Ministry',
            'ministry' => $ministry,
        ]);
    }

    public function update(Request $request, Ministry $ministry)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:ministries,name,' . $ministry->id,
            'description' => 'nullable|string',
        ]);

        $ministry->update($validated);
        return redirect()->route('admin.ministries.index')->with('success', 'Ministry updated successfully');
    }

    public function destroy(Ministry $ministry)
    {
        $name = $ministry->name;
        $ministry->delete();
        return redirect()->route('admin.ministries.index')->with('success', "Ministry \"$name\" deleted successfully");
    }
}
