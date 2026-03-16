<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get all order history logs associated with this status.
     * 
     * This is useful for seeing how many orders reached a specific 
     * milestone (e.g., how many orders are currently "Shipped").
     */
    public function histories(): HasMany
    {
        return $this->hasMany(OrderHistory::class, 'status_id');
    }

    /**
     * Scope a query to find a status by its slug.
     * Usage: DeliveryStatus::bySlug('pending')->first();
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
