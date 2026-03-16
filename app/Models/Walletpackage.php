<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Walletpackage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'validate', // Validity duration (e.g., in days)
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'integer',
        'validate' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Relationship: Get all products/items included in this wallet package.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class, 'package_id');
    }

    /**
     * Relationship: Get all user subscriptions associated with this package.
     */
    public function customerWallets(): HasMany
    {
        return $this->hasMany(CustomerWallet::class, 'package_id');
    }

    /**
     * Scope a query to only include active wallet packages.
     * Usage: Walletpackage::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Accessor: Get a formatted label for validity.
     * Usage in Blade: {{ $package->validity_label }}
     */
    public function getValidityLabelAttribute()
    {
        return $this->validate . ' Days';
    }
}
