<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Packeage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Get all items (products) included in this package.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class, 'package_id');
    }

    /**
     * Accessor for Package Image URL.
     * Usage: $package->image_url
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/images/package/' . $this->image) : url('upload/no_image.jpg');
    }

    /**
     * Scope a query to only include active packages.
     * Assuming status 1 = Active.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
