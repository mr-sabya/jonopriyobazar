<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'flash_sale_id',
        'product_id',
        'off',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'flash_sale_id' => 'integer',
        'product_id' => 'integer',
    ];

    /**
     * Get the Flash Sale this item belongs to.
     */
    public function flashSale(): BelongsTo
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }

    /**
     * Get the Product associated with this flash sale item.
     * Standardized to singular 'product'.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Helper to get the calculated flash sale price.
     * Assuming 'off' represents a percentage discount.
     * Usage: $item->flash_price
     */
    public function getFlashPriceAttribute()
    {
        if (!$this->product) {
            return 0;
        }

        $discountPercent = (float) $this->off;
        $originalPrice = $this->product->sale_price;

        $discountAmount = ($originalPrice * $discountPercent) / 100;

        return $originalPrice - $discountAmount;
    }
}
