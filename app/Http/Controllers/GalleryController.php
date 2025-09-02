<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Navigation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $query = Gallery::active()->ordered();

        if ($category) {
            $query->byCategory($category);
        }

        $galleries = $query->paginate(16);

        $categories = Gallery::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        $data = [
            'galleries' => $galleries,
            'categories' => $categories,
            'currentCategory' => $category,
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.gallery', $data);
    }

    private function getSiteSettings()
    {
        $settings = SiteSetting::all();
        $settingsArray = [];

        foreach ($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }

        return $settingsArray;
    }
}
