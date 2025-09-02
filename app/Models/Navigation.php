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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMainMenu($query)
    {
        return $query->whereNull('parent_id')->orderBy('sort_order');
    }
}
