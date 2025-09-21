<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'page_id',
        'parent_id',
        'sort_order',
        'is_active',
        'target',
        'icon'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Navigation::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Navigation::class, 'parent_id')->orderBy('sort_order');
    }

    public function page()
    {
        return $this->belongsTo(\App\Models\Page::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMainMenu($query)
    {
        return $query->whereNull('parent_id')->orderBy('sort_order');
    }

    /**
     * Get the navigation URL - either from page or manual URL
     */
    public function getNavigationUrl()
    {
        if ($this->page_id && $this->page) {
            return $this->page->slug === 'home' ? '/' : '/' . $this->page->slug;
        }

        return $this->url;
    }
}
