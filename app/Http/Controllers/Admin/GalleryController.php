<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(20);

        // Statistics for dashboard
        $stats = [
            'total' => Gallery::count(),
            'active' => Gallery::active()->count(),
            'categories' => Gallery::select('category')->distinct()->whereNotNull('category')->count(),
            'recent' => Gallery::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.galleries.index', compact('galleries', 'stats'));
    }

    public function create()
    {
        $categories = Gallery::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort();

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'category' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        Gallery::create($validated);

        if ($request->has('save_and_new')) {
            return redirect()->route('admin.galleries.create')
                ->with('success', 'Gallery item created successfully. Add another one below.');
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item created successfully.');
    }

    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $categories = Gallery::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort();

        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $gallery->sort_order;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $galleryIds = $request->input('ids', []);

        if (empty($galleryIds)) {
            return redirect()->route('admin.galleries.index')
                ->with('error', 'No gallery items selected for deletion.');
        }

        // Get galleries to delete their images
        $galleries = Gallery::whereIn('id', $galleryIds)->get();

        foreach ($galleries as $gallery) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
        }

        // Delete the galleries
        Gallery::whereIn('id', $galleryIds)->delete();

        $count = count($galleryIds);
        return redirect()->route('admin.galleries.index')
            ->with('success', "{$count} gallery item(s) deleted successfully.");
    }

    public function bulkToggleStatus(Request $request)
    {
        $galleryIds = $request->input('ids', []);
        $status = $request->input('status'); // 'activate' or 'deactivate'

        if (empty($galleryIds)) {
            return redirect()->route('admin.galleries.index')
                ->with('error', 'No gallery items selected.');
        }

        $isActive = $status === 'activate';
        Gallery::whereIn('id', $galleryIds)->update(['is_active' => $isActive]);

        $action = $isActive ? 'activated' : 'deactivated';
        $count = count($galleryIds);

        return redirect()->route('admin.galleries.index')
            ->with('success', "{$count} gallery item(s) {$action} successfully.");
    }
}
