<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPrize extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'prize_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'user_id' => 'integer',
        'prize_id' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Get the user who won or claimed this prize.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the details of the prize associated with this record.
     */
    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class, 'prize_id');
    }

    /**
     * Accessor: Get a human-readable label for the status.
     * Usage in Blade: {{ $userPrize->status_label }}
     */
    public function getStatusLabelAttribute()
    {
        $statusMap = [
            0 => 'Pending',
            1 => 'Delivered',
            2 => 'Canceled',
        ];

        return $statusMap[$this->status] ?? 'Unknown';
    }

    /**
     * Accessor: Get the CSS class for status badges.
     */
    public function getStatusClassAttribute()
    {
        $classMap = [
            0 => 'badge-warning',
            1 => 'badge-success',
            2 => 'badge-danger',
        ];

        return $classMap[$this->status] ?? 'badge-secondary';
    }

    /**
     * Scope a query to only include prizes that are yet to be delivered.
     */
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include prizes successfully delivered.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 1);
    }
}
