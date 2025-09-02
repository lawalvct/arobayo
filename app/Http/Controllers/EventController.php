<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Navigation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()
            ->latest('event_date')
            ->paginate(12);

        $data = [
            'events' => $events,
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.events', $data);
    }

    public function show($slug)
    {
        $event = Event::active()->where('slug', $slug)->firstOrFail();

        $data = [
            'event' => $event,
            'relatedEvents' => Event::active()
                ->where('id', '!=', $event->id)
                ->latest('event_date')
                ->take(3)
                ->get(),
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.event-detail', $data);
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
