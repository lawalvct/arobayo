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
        'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get the documents associated with this registration
     */
    public function documents()
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    /**
     * Get documents by type
     */
    public function getDocumentByType($type)
    {
        return $this->documents()->where('document_type', $type)->first();
    }

    /**
     * Check if all required documents are uploaded
     */
    public function hasAllRequiredDocuments()
    {
        $requiredTypes = ['membership_form', 'next_of_kin_form'];
        $uploadedTypes = $this->documents()->pluck('document_type')->toArray();

        return count(array_intersect($requiredTypes, $uploadedTypes)) === count($requiredTypes);
    }

    /**
     * Check if registration has any uploaded documents
     */
    public function hasDocuments()
    {
        return $this->documents()->count() > 0;
    }
}
