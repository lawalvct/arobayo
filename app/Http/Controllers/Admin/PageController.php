<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'required|string|in:default,home',
            'is_active' => 'boolean'
        ]);

        $page = Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'template' => $request->template,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully!');
    }

    public function show(Page $page)
    {
        $data = ['page' => $page];

        // If it's a home page, get the parsed home content
        if ($page->isHomePage()) {
            try {
                $homeContent = $page->home_content;
                // Ensure it's an array
                if (is_array($homeContent)) {
                    $data['homeContent'] = $homeContent;

                    // Add individual section enabled flags
                    $data['heroEnabled'] = $homeContent['hero']['enabled'] ?? true;
                    $data['missionEnabled'] = $homeContent['mission']['enabled'] ?? true;
                    $data['historyEnabled'] = $homeContent['history']['enabled'] ?? true;
                    $data['executivesEnabled'] = $homeContent['executives']['enabled'] ?? true;
                    $data['ctaEnabled'] = $homeContent['cta']['enabled'] ?? true;
                    $data['eventsEnabled'] = $homeContent['events']['enabled'] ?? true;
                } else {
                    $data['homeContent'] = null;
                }
            } catch (\Exception $e) {
                $data['homeContent'] = null;
            }
        }

        return view('admin.pages.show', $data);
    }

    public function edit(Page $page)
    {
        // If it's the home page, show the special home page editor
        if ($page->slug === 'home' || $page->template === 'home') {
            return $this->editHomePage($page);
        }

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // If it's the home page, handle it specially
        if ($page->slug === 'home' || $page->template === 'home') {
            return $this->updateHomePage($request, $page);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'required|string|in:default,home',
            'is_active' => 'boolean'
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'template' => $request->template,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        // Prevent deletion of home page
        if ($page->slug === 'home') {
            return redirect()->route('admin.pages.index')
                ->with('error', 'Cannot delete the home page!');
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully!');
    }

    /**
     * Special method to edit home page with sections
     */
    private function editHomePage(Page $page)
    {
        // Get current home page settings from content (stored as JSON)
        $homeSettings = $this->parseHomePageContent($page->content);

        // Get available slider images
        $sliderImages = Gallery::where('category', 'slider')->orWhere('category', 'home-slider')->get();

        return view('admin.pages.edit-home', compact('page', 'homeSettings', 'sliderImages'));
    }

    /**
     * Update home page with special handling
     */
    private function updateHomePage(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',

            // Hero Section
            'hero_enabled' => 'boolean',
            'hero_slides' => 'nullable|array',
            'hero_slides.*.title' => 'nullable|string|max:255',
            'hero_slides.*.subtitle' => 'nullable|string|max:500',
            'hero_slides.*.button_text' => 'nullable|string|max:100',
            'hero_slides.*.button_link' => 'nullable|string|max:255',
            'hero_slides.*.image' => 'nullable|string',

            // Mission Section
            'mission_enabled' => 'boolean',
            'mission_title' => 'nullable|string|max:255',
            'vision_text' => 'nullable|string',
            'mission_text' => 'nullable|string',
            'objective_text' => 'nullable|string',

            // History Section
            'history_enabled' => 'boolean',
            'history_title' => 'nullable|string|max:255',
            'history_text' => 'nullable|string',
            'history_image' => 'nullable|string',

            // Executives Section
            'executives_enabled' => 'boolean',
            'executives_title' => 'nullable|string|max:255',

            // CTA Section
            'cta_enabled' => 'boolean',
            'cta_title' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_link' => 'nullable|string|max:255',

            // Events Section
            'events_enabled' => 'boolean',
            'events_title' => 'nullable|string|max:255',
        ]);

        // Build home page content as JSON
        $homeContent = [
            'hero' => [
                'enabled' => $request->boolean('hero_enabled', true),
                'slides' => $request->hero_slides ?? []
            ],
            'mission' => [
                'enabled' => $request->boolean('mission_enabled', true),
                'title' => $request->mission_title ?? 'Our Mission, Vision & Objectives',
                'vision' => $request->vision_text ?? '',
                'mission' => $request->mission_text ?? '',
                'objective' => $request->objective_text ?? ''
            ],
            'history' => [
                'enabled' => $request->boolean('history_enabled', true),
                'title' => $request->history_title ?? 'Our History',
                'text' => $request->history_text ?? '',
                'image' => $request->history_image ?? ''
            ],
            'executives' => [
                'enabled' => $request->boolean('executives_enabled', true),
                'title' => $request->executives_title ?? 'Our Executives'
            ],
            'cta' => [
                'enabled' => $request->boolean('cta_enabled', true),
                'title' => $request->cta_title ?? 'Join Egbe Arobayo Today',
                'text' => $request->cta_text ?? '',
                'button_text' => $request->cta_button_text ?? 'Register Now',
                'button_link' => $request->cta_button_link ?? '/register'
            ],
            'events' => [
                'enabled' => $request->boolean('events_enabled', true),
                'title' => $request->events_title ?? 'Latest Events'
            ]
        ];

        $page->update([
            'title' => $request->title,
            'content' => json_encode($homeContent),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->boolean('is_active', true),
            'template' => 'home'
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Home page updated successfully!');
    }

    /**
     * Parse home page content from JSON
     */
    private function parseHomePageContent($content)
    {
        $defaultContent = [
            'hero' => [
                'enabled' => true,
                'slides' => [
                    [
                        'title' => 'Welcome to Egbe Arobayo',
                        'subtitle' => 'Preserving our heritage, building our future',
                        'button_text' => 'Learn More',
                        'button_link' => '#about',
                        'image' => '/images/slider/slide1.jpg'
                    ]
                ]
            ],
            'mission' => [
                'enabled' => true,
                'title' => 'Our Mission, Vision & Objectives',
                'vision' => 'To be the leading voice of Arobayo community worldwide.',
                'mission' => 'To unite and empower the Arobayo community through cultural preservation and development.',
                'objective' => 'To create sustainable opportunities for growth and development in our community.'
            ],
            'history' => [
                'enabled' => true,
                'title' => 'Our History',
                'text' => 'Egbe Arobayo has a rich history of bringing together the children of Arobayo...',
                'image' => '/images/history.jpg'
            ],
            'executives' => [
                'enabled' => true,
                'title' => 'Our Executives'
            ],
            'cta' => [
                'enabled' => true,
                'title' => 'Join Egbe Arobayo Today',
                'text' => 'Be part of something bigger. Join our community and help us build a better future for Arobayo.',
                'button_text' => 'Register Now',
                'button_link' => '/register'
            ],
            'events' => [
                'enabled' => true,
                'title' => 'Latest Events'
            ]
        ];

        if (empty($content)) {
            return $defaultContent;
        }

        $decoded = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $defaultContent;
        }

        // Merge with defaults to ensure all sections exist
        return array_merge_recursive($defaultContent, $decoded);
    }

    /**
     * Upload image for pages
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'nullable|string|in:hero,history,general,content'
        ]);

        $image = $request->file('image');
        $type = $request->type ?? 'general';

        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        // Store in appropriate directory
        $path = "uploads/pages/{$type}/" . $filename;
        $image->storeAs('public', $path);

        return response()->json([
            'success' => true,
            'path' => "/storage/{$path}",
            'filename' => $filename,
            'url' => asset("storage/{$path}")
        ]);
    }

    /**
     * Save page as draft (AJAX endpoint)
     */
    public function saveDraft(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Update page as draft (is_active = false)
        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => false, // Always save as draft
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Draft saved successfully',
            'last_saved' => $page->updated_at->format('g:i A')
        ]);
    }
}
