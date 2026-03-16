<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CustomerWallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'is_apply',
        'status',
        'valid_from',
        'valid_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'package_id' => 'integer',
        'is_apply' => 'boolean',
        'status' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    /**
     * Relationship: Get the package associated with this wallet subscription.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Walletpackage::class, 'package_id');
    }

    /**
     * Relationship: Get the user who owns this wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if the wallet package is currently active.
     * (Status is active and current date is within validity range)
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        $now = Carbon::now();

        return $this->status &&
            $this->valid_from <= $now &&
            $this->valid_to >= $now;
    }

    /**
     * Check if the wallet package has expired.
     * 
     * @return bool
     */
    public function isExpired(): bool
    {
        if (!$this->valid_to) {
            return false;
        }

        return Carbon::now()->gt($this->valid_to);
    }

    /**
     * Scope a query to only include active wallet subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->where('valid_from', '<=', Carbon::now())
            ->where('valid_to', '>=', Carbon::now());
    }
}
