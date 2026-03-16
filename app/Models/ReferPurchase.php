<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferPurchase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'order_id',
        'amount',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Casting 'date' to date ensures Carbon methods are available.
     * Casting 'amount' to double ensures numeric precision.
     */
    protected $casts = [
        'user_id' => 'integer',
        'date' => 'date',
        'order_id' => 'integer',
        'amount' => 'double',
    ];

    /**
     * Get the user who used their refer balance for this purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order associated with this refer balance usage.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope a query to only include refer purchases from the current month.
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }
}
