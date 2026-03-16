<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'method',          // e.g., Bkash, Nagad, Bank
        'account_details', // e.g., Phone number or Bank Acc
        'status',          // 0: Pending, 1: Approved, 2: Rejected
        'date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'user_id' => 'integer',
        'amount' => 'double',
        'status' => 'integer',
        'date' => 'date',
    ];

    /**
     * Get the user who requested this withdrawal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor: Get human-readable status label.
     * Usage in Blade: {{ $withdraw->status_label }}
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
            default => 'Unknown',
        };
    }

    /**
     * Accessor: Get CSS class for status badges.
     */
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            0 => 'badge-warning',
            1 => 'badge-success',
            2 => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    /**
     * Scope a query to only include pending withdrawals.
     */
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include successful withdrawals.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
