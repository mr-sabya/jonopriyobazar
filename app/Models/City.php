<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'thana_id',
        'delivery_charge',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'thana_id' => 'integer',
        'delivery_charge' => 'integer',
    ];

    /**
     * Get the Thana (Upazila/Sub-district) that this city/area belongs to.
     */
    public function thana(): BelongsTo
    {
        return $this->belongsTo(Thana::class, 'thana_id');
    }

    /**
     * Get all addresses associated with this city/area.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'city_id');
    }
}
