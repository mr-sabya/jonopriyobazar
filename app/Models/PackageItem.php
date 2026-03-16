<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'package_id',
        'product_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'package_id' => 'integer',
        'product_id' => 'integer',
    ];

    /**
     * Get the Package this item belongs to.
     * (Assuming the model name is Walletpackage based on your CustomerWallet model)
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Walletpackage::class, 'package_id');
    }

    /**
     * Get the Product associated with this package item.
     * Renamed to singular 'product' as it represents a single row.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
