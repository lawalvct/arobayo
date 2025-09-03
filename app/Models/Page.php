<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'meta_title',
        'meta_description',
        'is_active',
        'template'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if this is the home page
     */
    public function isHomePage()
    {
        return $this->slug === 'home' || $this->template === 'home';
    }

    /**
     * Get parsed content for home page
     */
    public function getHomeContentAttribute()
    {
        if (!$this->isHomePage()) {
            return null;
        }

        $content = json_decode($this->content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->getDefaultHomeContent();
        }

        return array_merge_recursive($this->getDefaultHomeContent(), $content ?? []);
    }

    /**
     * Get default home page content structure
     */
    private function getDefaultHomeContent()
    {
        return [
            'hero' => [
                'enabled' => true,
                'slides' => [
                    [
                        'title' => 'Welcome to Egbe Arobayo',
                        'subtitle' => 'Preserving our heritage, building our future',
                        'button_text' => 'Learn More',
                        'button_link' => '#about',
                        'image' => '/images/slider/slide1.jpg'
                    ]
                ]
            ],
            'mission' => [
                'enabled' => true,
                'title' => 'Our Mission, Vision & Objectives',
                'vision' => 'To be the leading voice of Arobayo community worldwide.',
                'mission' => 'To unite and empower the Arobayo community through cultural preservation and development.',
                'objective' => 'To create sustainable opportunities for growth and development in our community.'
            ],
            'history' => [
                'enabled' => true,
                'title' => 'Our History',
                'text' => 'Egbe Arobayo has a rich history of bringing together the children of Arobayo...',
                'image' => '/images/history.jpg'
            ],
            'executives' => [
                'enabled' => true,
                'title' => 'Our Executives'
            ],
            'cta' => [
                'enabled' => true,
                'title' => 'Join Egbe Arobayo Today',
                'text' => 'Be part of something bigger. Join our community and help us build a better future for Arobayo.',
                'button_text' => 'Register Now',
                'button_link' => '/register'
            ],
            'events' => [
                'enabled' => true,
                'title' => 'Latest Events'
            ]
        ];
    }

    /**
     * Check if a home page section is enabled
     */
    public function isSectionEnabled($section)
    {
        if (!$this->isHomePage()) {
            return false;
        }

        $content = $this->home_content;
        return $content[$section]['enabled'] ?? true;
    }
}
