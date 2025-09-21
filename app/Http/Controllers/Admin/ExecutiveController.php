<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExecutiveController extends Controller
{
    public function index()
    {
        $executives = Executive::ordered()->paginate(20);

        // Statistics for dashboard
        $stats = [
            'total' => Executive::count(),
            'active' => Executive::active()->count(),
            'inactive' => Executive::where('is_active', false)->count(),
            'recent' => Executive::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.executives.index', compact('executives', 'stats'));
    }

    public function create()
    {
        return view('admin.executives.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Handle social links
        if (isset($validated['social_links'])) {
            $socialLinks = array_filter($validated['social_links'], function($value) {
                return !empty($value);
            });
            $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('executives', 'public');
        }

        Executive::create($validated);

        if ($request->has('save_and_new')) {
            return redirect()->route('admin.executives.create')
                ->with('success', 'Executive created successfully. Add another one below.');
        }

        return redirect()->route('admin.executives.index')
            ->with('success', 'Executive created successfully.');
    }

    public function show(Executive $executive)
    {
        return view('admin.executives.show', compact('executive'));
    }

    public function edit(Executive $executive)
    {
        return view('admin.executives.edit', compact('executive'));
    }

    public function update(Request $request, Executive $executive)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $executive->sort_order;

        // Handle social links
        if (isset($validated['social_links'])) {
            $socialLinks = array_filter($validated['social_links'], function($value) {
                return !empty($value);
            });
            $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($executive->image) {
                Storage::disk('public')->delete($executive->image);
            }
            $validated['image'] = $request->file('image')->store('executives', 'public');
        }

        $executive->update($validated);

        return redirect()->route('admin.executives.index')
            ->with('success', 'Executive updated successfully.');
    }

    public function destroy(Executive $executive)
    {
        if ($executive->image) {
            Storage::disk('public')->delete($executive->image);
        }

        $executive->delete();

        return redirect()->route('admin.executives.index')
            ->with('success', 'Executive deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $executiveIds = $request->input('ids', []);

        if (empty($executiveIds)) {
            return redirect()->route('admin.executives.index')
                ->with('error', 'No executives selected for deletion.');
        }

        // Get executives to delete their images
        $executives = Executive::whereIn('id', $executiveIds)->get();

        foreach ($executives as $executive) {
            if ($executive->image) {
                Storage::disk('public')->delete($executive->image);
            }
        }

        // Delete the executives
        Executive::whereIn('id', $executiveIds)->delete();

        $count = count($executiveIds);
        return redirect()->route('admin.executives.index')
            ->with('success', "{$count} executive(s) deleted successfully.");
    }

    public function bulkToggleStatus(Request $request)
    {
        $executiveIds = $request->input('ids', []);
        $status = $request->input('status'); // 'activate' or 'deactivate'

        if (empty($executiveIds)) {
            return redirect()->route('admin.executives.index')
                ->with('error', 'No executives selected.');
        }

        $isActive = $status === 'activate';
        Executive::whereIn('id', $executiveIds)->update(['is_active' => $isActive]);

        $action = $isActive ? 'activated' : 'deactivated';
        $count = count($executiveIds);

        return redirect()->route('admin.executives.index')
            ->with('success', "{$count} executive(s) {$action} successfully.");
    }
}
