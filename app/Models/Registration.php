<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'occupation',
        'membership_type',
        'status',
        'notes',
    ];

    public function documents()
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
