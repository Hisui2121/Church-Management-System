<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // <--- IDAGDAG MO ITO DITO

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        $banner = Banner::create($validated);

        // Log to audit trail
        AuditLog::record('Created', 'banners', $banner->id, "Banner '{$banner->title}' created");

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $path = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $banner->update($validated);

        // Log to audit trail
        AuditLog::record('Updated', 'banners', $banner->id, "Banner '{$banner->title}' updated");

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $bannerTitle = $banner->title;
        $bannerId = $banner->id;
        $banner->delete();

        // Log to audit trail
        AuditLog::record('Deleted', 'banners', $bannerId, "Banner '{$bannerTitle}' deleted");

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
    }
}
