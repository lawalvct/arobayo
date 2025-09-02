<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\Navigation;
use App\Models\Executive;
use App\Models\Event;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Site Settings
        $siteSettings = [
            [
                'key' => 'site_name',
                'value' => 'Egbe Arobayo',
                'type' => 'text',
                'description' => 'Website name'
            ],
            [
                'key' => 'hero_title',
                'value' => 'Welcome to Egbe Arobayo',
                'type' => 'text',
                'description' => 'Hero section title'
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Preserving Yoruba culture, traditions, and values for future generations. Join us in celebrating our rich heritage.',
                'type' => 'textarea',
                'description' => 'Hero section subtitle'
            ],
            [
                'key' => 'vision',
                'value' => 'To be the leading platform for preserving and promoting Yoruba culture, fostering unity among our people worldwide.',
                'type' => 'textarea',
                'description' => 'Organization vision'
            ],
            [
                'key' => 'mission',
                'value' => 'To preserve, promote, and celebrate Yoruba traditions while creating opportunities for cultural education and community development.',
                'type' => 'textarea',
                'description' => 'Organization mission'
            ],
            [
                'key' => 'objectives',
                'value' => 'Cultural preservation, education, community building, youth engagement, and promoting Yoruba values in modern society.',
                'type' => 'textarea',
                'description' => 'Organization objectives'
            ],
            [
                'key' => 'history_text',
                'value' => 'Egbe Arobayo has been at the forefront of preserving Yoruba culture for decades. Our organization was founded with the vision of maintaining our ancestral traditions while adapting to modern times.',
                'type' => 'textarea',
                'description' => 'History section text'
            ],
            [
                'key' => 'footer_description',
                'value' => 'Preserving and promoting Yoruba culture, traditions, and values for future generations.',
                'type' => 'textarea',
                'description' => 'Footer description'
            ],
            [
                'key' => 'email',
                'value' => 'info@egbearobayo.org',
                'type' => 'text',
                'description' => 'Contact email'
            ],
            [
                'key' => 'phone',
                'value' => '+234 xxx xxx xxxx',
                'type' => 'text',
                'description' => 'Contact phone'
            ],
            [
                'key' => 'address',
                'value' => 'Lagos, Nigeria',
                'type' => 'text',
                'description' => 'Contact address'
            ],
        ];

        foreach ($siteSettings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Navigation Menu
        $navigationItems = [
            [
                'label' => 'About Us',
                'url' => '/about',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'label' => 'History',
                'url' => '/history',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'label' => 'Leadership',
                'url' => '/leadership',
                'sort_order' => 3,
                'is_active' => true
            ],
        ];

        foreach ($navigationItems as $item) {
            Navigation::updateOrCreate(
                ['label' => $item['label']],
                $item
            );
        }

        // Sample Executives
        $executives = [
            [
                'name' => 'Chief Adebayo Ogundimu',
                'position' => 'President',
                'bio' => 'A distinguished leader with over 20 years of experience in cultural preservation and community development.',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Mrs. Folake Adeyemi',
                'position' => 'Vice President',
                'bio' => 'Passionate advocate for women empowerment and cultural education in the Yoruba community.',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Dr. Kunle Olatunji',
                'position' => 'Secretary General',
                'bio' => 'Academic and researcher specializing in Yoruba history and cultural studies.',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Mr. Wale Ogundipe',
                'position' => 'Treasurer',
                'bio' => 'Financial expert with extensive experience in non-profit organization management.',
                'sort_order' => 4,
                'is_active' => true
            ],
        ];

        foreach ($executives as $executive) {
            Executive::updateOrCreate(
                ['name' => $executive['name']],
                $executive
            );
        }

        // Sample Events
        $events = [
            [
                'title' => 'Annual Yoruba Cultural Festival 2025',
                'slug' => 'annual-yoruba-cultural-festival-2025',
                'description' => 'Join us for our biggest cultural celebration featuring traditional music, dance, food, and arts. This year\'s festival promises to be bigger and better with performances from renowned Yoruba artists.',
                'event_date' => '2025-12-15 10:00:00',
                'location' => 'National Theatre, Lagos',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'title' => 'Youth Leadership Summit',
                'slug' => 'youth-leadership-summit',
                'description' => 'Empowering the next generation of Yoruba leaders through workshops, mentorship, and networking opportunities.',
                'event_date' => '2025-10-20 09:00:00',
                'location' => 'University of Lagos',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'title' => 'Traditional Wedding Ceremony Workshop',
                'slug' => 'traditional-wedding-ceremony-workshop',
                'description' => 'Learn about the significance and proper conduct of traditional Yoruba wedding ceremonies.',
                'event_date' => '2025-11-05 14:00:00',
                'location' => 'Community Center, Ikeja',
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'title' => 'Yoruba Language Classes for Beginners',
                'slug' => 'yoruba-language-classes-beginners',
                'description' => 'Free Yoruba language classes for beginners. Learn to speak, read, and write Yoruba language.',
                'event_date' => '2025-09-30 16:00:00',
                'location' => 'Egbe Arobayo Center',
                'is_featured' => true,
                'is_active' => true
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['slug' => $event['slug']],
                $event
            );
        }
    }
}
