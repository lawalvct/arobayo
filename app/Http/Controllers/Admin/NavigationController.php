<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NavigationController extends Controller
{
    public function index()
    {
        // Get all navigations first to check the data structure
        $allNavigations = Navigation::with('page')->orderBy('sort_order')->get();

        // Get top-level navigations (parent_id is null)
        $navigations = Navigation::with(['children', 'page'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        // If no top-level items exist but we have navigations, show all items
        if ($navigations->isEmpty() && $allNavigations->isNotEmpty()) {
            $navigations = $allNavigations;
        }

        return view('admin.navigations.index', compact('navigations', 'allNavigations'));
    }

    public function create()
    {
        $parentNavigations = Navigation::whereNull('parent_id')->active()->orderBy('sort_order')->get();
        $pages = Page::active()->orderBy('title')->get();
        return view('admin.navigations.create', compact('parentNavigations', 'pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required_without:page_id|nullable|string|max:255',
            'page_id' => 'required_without:url|nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:navigations,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:100'
        ]);

        // Auto-assign sort order if not provided
        if (!$request->sort_order) {
            $maxOrder = Navigation::where('parent_id', $request->parent_id)->max('sort_order') ?? 0;
            $request->merge(['sort_order' => $maxOrder + 1]);
        }

        Navigation::create([
            'label' => $request->label,
            'url' => $request->url ?: null, // Ensure null instead of empty string
            'page_id' => $request->page_id ?: null, // Ensure null instead of empty string
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order,
            'is_active' => $request->boolean('is_active', true),
            'target' => $request->target,
            'icon' => $request->icon ?: null // Ensure null instead of empty string
        ]);

        return redirect()->route('admin.navigations.index')
            ->with('success', 'Navigation item created successfully!');
    }

    public function show(Navigation $navigation)
    {
        $navigation->load('children', 'parent');
        return view('admin.navigations.show', compact('navigation'));
    }

    public function edit(Navigation $navigation)
    {
        $parentNavigations = Navigation::whereNull('parent_id')
            ->where('id', '!=', $navigation->id)
            ->active()
            ->orderBy('sort_order')
            ->get();

        $pages = Page::active()->orderBy('title')->get();

        return view('admin.navigations.edit', compact('navigation', 'parentNavigations', 'pages'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required_without:page_id|nullable|string|max:255',
            'page_id' => 'required_without:url|nullable|exists:pages,id',
            'parent_id' => [
                'nullable',
                'exists:navigations,id',
                Rule::notIn([$navigation->id]) // Prevent self-parent
            ],
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:100'
        ]);

        $navigation->update([
            'label' => $request->label,
            'url' => $request->url ?: null, // Ensure null instead of empty string
            'page_id' => $request->page_id ?: null, // Ensure null instead of empty string
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order ?? $navigation->sort_order,
            'is_active' => $request->boolean('is_active'),
            'target' => $request->target,
            'icon' => $request->icon ?: null // Ensure null instead of empty string
        ]);

        return redirect()->route('admin.navigations.index')
            ->with('success', 'Navigation item updated successfully!');
    }

    public function destroy(Navigation $navigation)
    {
        // Check if it has children
        if ($navigation->children()->count() > 0) {
            return redirect()->route('admin.navigations.index')
                ->with('error', 'Cannot delete navigation item that has sub-items. Please delete or move the sub-items first.');
        }

        $navigation->delete();

        return redirect()->route('admin.navigations.index')
            ->with('success', 'Navigation item deleted successfully!');
    }

    /**
     * Update navigation order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:navigations,id',
            'items.*.parent_id' => 'nullable|exists:navigations,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            Navigation::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'sort_order' => $item['sort_order']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Navigation order updated successfully']);
    }

    /**
     * Toggle navigation item active status
     */
    public function toggleStatus(Navigation $navigation)
    {
        $navigation->update([
            'is_active' => !$navigation->is_active
        ]);

        $status = $navigation->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.navigations.index')
            ->with('success', "Navigation item {$status} successfully!");
    }

    /**
     * Bulk delete navigation items
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:navigations,id'
        ]);

        // Check for items with children
        $itemsWithChildren = Navigation::whereIn('id', $request->ids)
            ->whereHas('children')
            ->count();

        if ($itemsWithChildren > 0) {
            return redirect()->route('admin.navigations.index')
                ->with('error', 'Cannot delete navigation items that have sub-items. Please delete or move the sub-items first.');
        }

        Navigation::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.navigations.index')
            ->with('success', count($request->ids) . ' navigation items deleted successfully!');
    }

    /**
     * Bulk toggle status for navigation items
     */
    public function bulkToggleStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:navigations,id',
            'status' => 'required|boolean'
        ]);

        Navigation::whereIn('id', $request->ids)->update([
            'is_active' => $request->status
        ]);

        $action = $request->status ? 'activated' : 'deactivated';

        return redirect()->route('admin.navigations.index')
            ->with('success', count($request->ids) . " navigation items {$action} successfully!");
    }
}
