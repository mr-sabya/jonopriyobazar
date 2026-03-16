<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class FlashSale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Even though the migration uses 'string', casting them to 'datetime'
     * allows you to use Carbon methods (format, diffForHumans, etc.)
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relationship: Get all products/items included in this flash sale.
     */
    public function items(): HasMany
    {
        return $this->hasMany(FlashSaleItem::class, 'flash_sale_id');
    }

    /**
     * Check if the flash sale is currently running.
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if the flash sale has ended.
     * 
     * @return bool
     */
    public function isExpired(): bool
    {
        return Carbon::now()->gt($this->end_date);
    }

    /**
     * Scope a query to only include the currently active flash sale.
     * Usage: FlashSale::active()->first();
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }
}
