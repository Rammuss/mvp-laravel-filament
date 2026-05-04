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

    public function setGoogleMapsUrlAttribute($value): void
    {
        $url = trim((string) $value);

        if ($url === '') {
            $this->attributes['google_maps_url'] = null;
            return;
        }

        $this->attributes['google_maps_url'] = $this->expandGoogleMapsShortUrl($url) ?? $url;
    }

    private function expandGoogleMapsShortUrl(string $url): ?string
    {
        if (!str_contains($url, 'maps.app.goo.gl')) {
            return null;
        }

        if (!function_exists('curl_init')) {
            return null;
        }

        $ch = curl_init($url);
        if (!$ch) {
            return null;
        }

        curl_setopt_array($ch, [
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
        ]);

        curl_exec($ch);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        if (!is_string($effectiveUrl) || $effectiveUrl === '') {
            return null;
        }

        return $effectiveUrl;
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(PropertyLead::class);
    }
}
