<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Navigation;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Make sure session flash data is properly preserved on redirects
        if (Session::has('success')) {
            Session::reflash();
        }

        // Share navigation data with all views
        View::composer('*', function ($view) {
            try {
                // Get navigation items with active children
                $globalNavigations = Navigation::where('is_active', true)
                    ->whereNull('parent_id')
                    ->with(['children' => function($query) {
                        $query->where('is_active', true)->orderBy('sort_order');
                    }])
                    ->orderBy('sort_order')
                    ->get();

                // Get site settings
                $settings = SiteSetting::all();
                $siteSettings = [];
                foreach ($settings as $setting) {
                    $siteSettings[$setting->key] = $setting->value;
                }

                // Add defaults if not set
                $siteSettings = array_merge([
                    'site_name' => config('app.name', 'Egbe Arobayo'),
                    'footer_description' => 'Preserving and promoting Yoruba culture, traditions, and values for future generations.',
                ], $siteSettings);

                $view->with('globalNavigations', $globalNavigations);
                $view->with('siteSettings', $siteSettings);
            } catch (\Exception $e) {
                // If database is not available or migration hasn't run, provide defaults
                $view->with('globalNavigations', collect());
                $view->with('siteSettings', [
                    'site_name' => config('app.name', 'Egbe Arobayo'),
                    'footer_description' => 'Preserving and promoting Yoruba culture, traditions, and values for future generations.'
                ]);
            }
        });
    }
}
