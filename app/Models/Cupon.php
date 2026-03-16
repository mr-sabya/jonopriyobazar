<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Cupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'code',
        'limit',
        'expire_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'integer',
        'limit' => 'integer',
        'expire_date' => 'date',
    ];

    /**
     * Relationship: An individual coupon can be used in many orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'cupon_id');
    }

    /**
     * Check if the coupon is currently valid (Not expired and under limit).
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isLimitReached();
    }

    /**
     * Check if the coupon has expired.
     * 
     * @return bool
     */
    public function isExpired(): bool
    {
        return Carbon::now()->gt($this->expire_date->endOfDay());
    }

    /**
     * Check if the usage limit has been reached.
     * 
     * @return bool
     */
    public function isLimitReached(): bool
    {
        // If limit is 0, assume it is unlimited
        if ($this->limit <= 0) {
            return false;
        }

        return $this->orders()->count() >= $this->limit;
    }

    /**
     * Scope a query to only include coupons that haven't expired.
     */
    public function scopeActive($query)
    {
        return $query->where('expire_date', '>=', Carbon::today());
    }
}
