<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletPurchase extends Model
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
     * Casting 'date' ensures Carbon methods like ->format() are available.
     * Casting 'amount' to double ensures precision for financial calculations.
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_id' => 'integer',
        'date' => 'date',
        'amount' => 'double',
    ];

    /**
     * Get the user who made this purchase using their wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order associated with this wallet transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope a query to only include wallet purchases from the current month.
     * Usage: WalletPurchase::currentMonth()->sum('amount');
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }

    /**
     * Scope a query to filter by a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
