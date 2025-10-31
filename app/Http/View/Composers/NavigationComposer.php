<?php

namespace App\Http\View\Composers;

use App\Models\Navigation;
use App\Models\SiteSetting;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $navigation = Navigation::active()->mainMenu()->with(['children' => function($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])->get();

        $settings = SiteSetting::all();
        $siteSettings = [];
        foreach ($settings as $setting) {
            $siteSettings[$setting->key] = $setting->value;
        }

        $view->with([
            'navigation' => $navigation,
            'siteSettings' => $siteSettings
        ]);
    }
}