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
                // Get navigation items
                $navigation = Navigation::with('children')
                    ->mainMenu()
                    ->active()
                    ->orderBy('sort_order')
                    ->get();

                // Get site settings (assuming you have this model, if not, we'll use defaults)
                $siteSettings = [
                    'site_name' => config('app.name', 'Egbe Arobayo'),
                    'footer_description' => 'Preserving and promoting Yoruba culture, traditions, and values for future generations.',
                    'phone' => '+234 XXX XXX XXXX',
                    'email' => 'info@egbearobayo.com',
                    'address' => 'Lagos, Nigeria',
                    'facebook_url' => '#',
                    'twitter_url' => '#',
                    'instagram_url' => '#'
                ];

                $view->with('navigation', $navigation);
                $view->with('siteSettings', $siteSettings);
            } catch (\Exception $e) {
                // If database is not available or migration hasn't run, provide defaults
                $view->with('navigation', collect());
                $view->with('siteSettings', [
                    'site_name' => config('app.name', 'Egbe Arobayo'),
                    'footer_description' => 'Preserving and promoting Yoruba culture, traditions, and values for future generations.'
                ]);
            }
        });
    }
}
