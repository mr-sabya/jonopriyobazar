<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPoint extends Model
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
        'point',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Casting 'date' to date ensures Carbon methods are available.
     * Casting 'point' to integer ensures numeric consistency.
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_id' => 'integer',
        'date' => 'date',
        'point' => 'integer',
    ];

    /**
     * Get the user who earned these points.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order that generated these points.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope a query to only include points earned in the current month.
     * Usage: UserPoint::currentMonth()->sum('point');
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }

    /**
     * Scope a query to filter points for a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
