<?php<?php



namespace Database\Seeders;namespace Database\Seeders;



use Illuminate\Database\Console\Seeds\WithoutModelEvents;use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;use Illuminate\Database\Seeder;

use App\Models\Page;use App\Models\Page;

use App\Models\Navigation;use App\Models\Navigation;



class NavigationPageSeeder extends Seederclass NavigationPageSeeder extends Seeder

{{

    /**    /**

     * Run the database seeder.     * Run the database seeder.

     */     */

    public function run(): void    public function run(): void

    {    {

        // Clear existing navigation items        // Clear existing navigation items

        Navigation::truncate();        Navigation::truncate();



        // Get existing pages        // Get existing pages

        $pages = Page::all();        $pages = Page::all();



        if ($pages->count() === 0) {        if ($pages->count() === 0) {

            // Create some basic pages if none exist            // Create some basic pages if none exist

            $homePage = Page::create([            $homePage = Page::create([

                'title' => 'Home',                'title' => 'Home',

                'slug' => 'home',                'slug' => 'home',

                'content' => '{}',                'content' => '{}',

                'template' => 'home',                'template' => 'home',

                'is_active' => true,                'is_active' => true,

                'meta_title' => 'Welcome to Egbe Arobayo',                'meta_title' => 'Welcome to Egbe Arobayo',

                'meta_description' => 'Official website of Egbe Arobayo organization'                'meta_description' => 'Official website of Egbe Arobayo organization'

            ]);            ]);



            $aboutPage = Page::create([            $aboutPage = Page::create([

                'title' => 'About Us',                'title' => 'About Us',

                'slug' => 'about',                'slug' => 'about',

                'content' => '<h2>About Egbe Arobayo</h2><p>Learn more about our organization...</p>',                'content' => '<h2>About Egbe Arobayo</h2><p>Learn more about our organization...</p>',

                'template' => 'default',                'template' => 'default',

                'is_active' => true,                'is_active' => true,

                'meta_title' => 'About Us - Egbe Arobayo',                'meta_title' => 'About Us - Egbe Arobayo',

                'meta_description' => 'Learn about Egbe Arobayo organization'                'meta_description' => 'Learn about Egbe Arobayo organization'

            ]);            ]);



            $contactPage = Page::create([            $contactPage = Page::create([

                'title' => 'Contact Us',                'title' => 'Contact Us',

                'slug' => 'contact',                'slug' => 'contact',

                'content' => '<h2>Contact Us</h2><p>Get in touch with us...</p>',                'content' => '<h2>Contact Us</h2><p>Get in touch with us...</p>',

                'template' => 'default',                'template' => 'default',

                'is_active' => true,                'is_active' => true,

                'meta_title' => 'Contact Us - Egbe Arobayo',                'meta_title' => 'Contact Us - Egbe Arobayo',

                'meta_description' => 'Contact Egbe Arobayo organization'                'meta_description' => 'Contact Egbe Arobayo organization'

            ]);            ]);



            $pages = collect([$homePage, $aboutPage, $contactPage]);            $pages = collect([$homePage, $aboutPage, $contactPage]);

        }        }



        // Create navigation items linked to pages        // Create navigation items linked to pages

        $navigationItems = [        $navigationItems = [

            [            [

                'label' => 'Home',                'label' => 'Home',

                'page_id' => $pages->where('slug', 'home')->first()?->id,                'page_id' => $pages->where('slug', 'home')->first()?->id,

                'url' => null,                'url' => null,

                'sort_order' => 1,                'sort_order' => 1,

                'is_active' => true,                'is_active' => true,

                'target' => '_self',                'target' => '_self',

                'icon' => 'fas fa-home'                'icon' => 'fas fa-home'

            ],            ],

            [            [

                'label' => 'About',                'label' => 'About',

                'page_id' => $pages->where('slug', 'about')->first()?->id,                'page_id' => $pages->where('slug', 'about')->first()?->id,

                'url' => null,                'url' => null,

                'sort_order' => 2,                'sort_order' => 2,

                'is_active' => true,                'is_active' => true,

                'target' => '_self',                'target' => '_self',

                'icon' => 'fas fa-info-circle'                'icon' => 'fas fa-info-circle'

            ],            ],

            [            [

                'label' => 'Events',                'label' => 'Events',

                'page_id' => null,                'page_id' => null,

                'url' => '/events',                'url' => '/events',

                'sort_order' => 3,                'sort_order' => 3,

                'is_active' => true,                'is_active' => true,

                'target' => '_self',                'target' => '_self',

                'icon' => 'fas fa-calendar'                'icon' => 'fas fa-calendar'

            ],            ],

            [            [

                'label' => 'Gallery',                'label' => 'Gallery',

                'page_id' => null,                'page_id' => null,

                'url' => '/gallery',                'url' => '/gallery',

                'sort_order' => 4,                'sort_order' => 4,

                'is_active' => true,                'is_active' => true,

                'target' => '_self',                'target' => '_self',

                'icon' => 'fas fa-images'                'icon' => 'fas fa-images'

            ],            ],

            [            [

                'label' => 'Contact',                'label' => 'Contact',

                'page_id' => $pages->where('slug', 'contact')->first()?->id,                'page_id' => $pages->where('slug', 'contact')->first()?->id,

                'url' => null,                'url' => null,

                'sort_order' => 5,                'sort_order' => 5,

                'is_active' => true,                'is_active' => true,

                'target' => '_self',                'target' => '_self',

                'icon' => 'fas fa-envelope'                'icon' => 'fas fa-envelope'

            ]            ]

        ];        ];



        foreach ($navigationItems as $item) {        foreach ($navigationItems as $item) {

            Navigation::create($item);            Navigation::create($item);

        }        }



        $this->command->info('Created ' . count($navigationItems) . ' navigation items linked to pages');        $this->command->info('Created ' . count($navigationItems) . ' navigation items linked to pages');

    }    }

}}Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}
