<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclePhoto extends Model
{
    protected $fillable = [
        'vehicle_id', 'path', 'alt_text', 'position', 'is_cover',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
   

}
