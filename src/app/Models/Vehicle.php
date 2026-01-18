<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'slug', 'title', 'description', 'price',
        'brand', 'model', 'version',
        'year', 'model_year', 'mileage_km',
        'fuel', 'transmission', 'color',
        'status', 'featured', 'whatsapp_phone', 'published_at',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    public function getCoverPhotoAttribute()
    {
        return $this->photos()
            ->orderByDesc('is_cover')
            ->orderBy('position')
            ->first();
    }

    public function getWhatsappLinkAttribute()
    {
        if (!$this->whatsapp_phone) return null;

        $phone = preg_replace('/\D/', '', $this->whatsapp_phone);
        $vehicleUrl = route('vehicles.show', $this->slug);
        $message = urlencode(
        "Olá! Tenho interesse no veículo:\n\n" .
        "{$this->title}\n" .
        "Link: {$vehicleUrl}"
        );

        return "https://wa.me/55{$phone}?text={$message}";
    }
}
