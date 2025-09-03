<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class HomePageSeeder extends Seeder
{
    public function run()
    {
        $homeContent = [
            'hero' => [
                'enabled' => true,
                'slides' => [
                    [
                        'title' => 'Welcome to Egbe Arobayo',
                        'subtitle' => 'Preserving our heritage, building our future together as one community',
                        'button_text' => 'Learn More',
                        'button_link' => '#about',
                        'image' => '/uploads/slides/slide1.jpg'
                    ],
                    [
                        'title' => 'Unity in Diversity',
                        'subtitle' => 'Celebrating our rich culture and traditions while embracing progress',
                        'button_text' => 'Join Us',
                        'button_link' => '/register',
                        'image' => '/uploads/slides/slide2.jpg'
                    ],
                    [
                        'title' => 'Building Tomorrow',
                        'subtitle' => 'Empowering our youth and supporting community development',
                        'button_text' => 'Get Involved',
                        'button_link' => '/events',
                        'image' => '/uploads/slides/slide3.jpg'
                    ]
                ]
            ],
            'mission' => [
                'enabled' => true,
                'title' => 'Our Mission, Vision & Objectives',
                'vision' => 'To be the leading voice of the Arobayo community worldwide, fostering unity, progress, and cultural preservation for current and future generations.',
                'mission' => 'To unite and empower the Arobayo community through cultural preservation, education, economic development, and social initiatives that benefit all members.',
                'objective' => 'To create sustainable opportunities for growth, provide educational scholarships, support community projects, and maintain strong cultural ties across all generations.'
            ],
            'history' => [
                'enabled' => true,
                'title' => 'Our Rich History',
                'text' => 'Egbe Arobayo was founded with the noble vision of uniting the children of Arobayo both at home and in the diaspora. Our organization has been instrumental in promoting the rich cultural heritage of our community while fostering development and progress. Through the years, we have organized numerous cultural events, supported educational initiatives, and provided a platform for networking and collaboration among our members. Our history is one of unity, resilience, and commitment to the betterment of our community.',
                'image' => '/uploads/history/arobayo-history.jpg'
            ],
            'executives' => [
                'enabled' => true,
                'title' => 'Meet Our Executives'
            ],
            'cta' => [
                'enabled' => true,
                'title' => 'Join Egbe Arobayo Today',
                'text' => 'Be part of something bigger. Join our community and help us build a better future for Arobayo. Whether you are at home or abroad, your contribution matters.',
                'button_text' => 'Become a Member',
                'button_link' => '/register'
            ],
            'events' => [
                'enabled' => true,
                'title' => 'Latest Events & News'
            ]
        ];

        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Welcome to Egbe Arobayo',
                'content' => json_encode($homeContent),
                'meta_title' => 'Egbe Arobayo - Uniting the Children of Arobayo Worldwide',
                'meta_description' => 'Egbe Arobayo is a cultural organization dedicated to uniting the children of Arobayo worldwide, preserving our heritage, and fostering community development.',
                'is_active' => true,
                'template' => 'home'
            ]
        );

        // Create some other sample pages
        Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'content' => '<h1>About Egbe Arobayo</h1>
                <p>Egbe Arobayo is a cultural and social organization that brings together the sons and daughters of Arobayo, both at home and in the diaspora.</p>

                <h2>Our Story</h2>
                <p>Founded with the vision of preserving our rich cultural heritage while promoting unity and development, Egbe Arobayo has been at the forefront of community building and cultural preservation.</p>

                <h2>What We Do</h2>
                <ul>
                    <li>Organize cultural events and festivals</li>
                    <li>Support educational initiatives</li>
                    <li>Promote community development projects</li>
                    <li>Provide networking opportunities for members</li>
                    <li>Preserve and promote our traditional values</li>
                </ul>

                <h2>Join Us</h2>
                <p>Whether you are a son or daughter of Arobayo living at home or abroad, you are welcome to join our growing community. Together, we can achieve great things.</p>',
                'meta_title' => 'About Egbe Arobayo - Our Mission and Vision',
                'meta_description' => 'Learn about Egbe Arobayo, our mission to unite the children of Arobayo worldwide, and our commitment to cultural preservation and community development.',
                'is_active' => true,
                'template' => 'default'
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'content' => '<h1>Contact Egbe Arobayo</h1>
                <p>We would love to hear from you. Get in touch with us using any of the methods below.</p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h3>Get In Touch</h3>
                        <p><strong>Email:</strong> info@egbearobayo.com</p>
                        <p><strong>Phone:</strong> +234 xxx xxx xxxx</p>
                        <p><strong>Address:</strong> Arobayo Community<br>Nigeria</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Office Hours</h3>
                        <p><strong>Monday - Friday:</strong> 9:00 AM - 5:00 PM</p>
                        <p><strong>Saturday:</strong> 10:00 AM - 2:00 PM</p>
                        <p><strong>Sunday:</strong> Closed</p>
                    </div>
                </div>

                <h3>Send Us a Message</h3>
                <p>For membership inquiries, event information, or general questions, please don\'t hesitate to reach out. We look forward to hearing from you!</p>',
                'meta_title' => 'Contact Egbe Arobayo - Get in Touch',
                'meta_description' => 'Contact Egbe Arobayo for membership inquiries, event information, or any questions about our community organization.',
                'is_active' => true,
                'template' => 'default'
            ]
        );
    }
}
