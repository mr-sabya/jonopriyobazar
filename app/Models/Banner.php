<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image',
        'link',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Accessor for Banner Image URL
     * Call this in blade using: $banner->image_url
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/banners/' . $this->image) : url('upload/no_image.jpg');
    }

    /**
     * Scope a query to only include active banners.
     * Usage: Banner::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
