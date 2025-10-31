<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\Page;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run()
    {
        // Get pages for navigation
        $homePage = Page::where('slug', 'home')->first();
        
        // Create main navigation items
        Navigation::create([
            'label' => 'About Us',
            'url' => '/about',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Navigation::create([
            'label' => 'Contact',
            'url' => '/contact',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Navigation::create([
            'label' => 'News',
            'url' => '/news',
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}