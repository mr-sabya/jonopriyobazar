<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orderitem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'image',
        'quantity',
        'price'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'price' => 'double',
    ];

    /**
     * Get the Order that this item belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the Product associated with this order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Accessor: Get the subtotal for this specific item (Price * Quantity).
     * Usage in Blade: {{ $item->subtotal }}৳
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Accessors: Get the image URL for the item.
     * Note: Usually uses the snapshot image saved during order time.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/images/' . $this->image) : url('upload/no_image.jpg');
    }
}
