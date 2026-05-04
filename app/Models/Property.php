<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'operation_type',
        'property_type',
        'price',
        'currency',
        'bedrooms',
        'bathrooms',
        'area_m2',
        'city',
        'address',
        'whatsapp_number',
        'google_maps_url',
        'short_description',
        'long_description',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area_m2' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(PropertyLead::class);
    }
}
