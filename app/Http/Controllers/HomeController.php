<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Executive;
use App\Models\Gallery;
use App\Models\Navigation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'featuredEvents' => Event::active()->featured()->latest()->take(4)->get(),
            'executives' => Executive::active()->ordered()->get(),
            'galleryImages' => Gallery::active()->ordered()->take(8)->get(),
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.home', $data);
    }

    public function page($slug)
    {
        $page = \App\Models\Page::active()->where('slug', $slug)->firstOrFail();

        $data = [
            'page' => $page,
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.page', $data);
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
