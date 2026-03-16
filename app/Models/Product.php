<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'quantity',
        'sale_price',
        'actual_price',
        'off',
        'is_percentage',
        'point',
        'image',
        'description',
        'is_stock',
        'added_by'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'sale_price' => 'double',
        'actual_price' => 'double',
        'quantity' => 'integer',
        'point' => 'integer',
        'is_stock' => 'boolean',
        'is_percentage' => 'boolean',
    ];

    /**
     * Relationship: Categories associated with this product.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relationship: Items in Wishlists.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    /**
     * Relationship: Link to an active Flash Sale Item.
     */
    public function flashSaleItem(): HasOne
    {
        return $this->hasOne(FlashSaleItem::class, 'product_id');
    }

    /**
     * Relationship: Times this product has been ordered.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(Orderitem::class, 'product_id');
    }

    /**
     * Accessor: Image URL with fallback to demo image.
     */
    public function getImageUrlAttribute()
    {
        $path = 'upload/images/' . $this->image;

        if (!empty($this->image) && File::exists(public_path($path))) {
            return asset($path);
        }

        return asset('frontend/images/demo-image.png');
    }

    /**
     * Accessor: Sanitized description for clean UI display.
     */
    public function getCleanDescriptionAttribute()
    {
        $content = $this->description;
        // Replace multiple <br> with one
        $content = preg_replace('/(<br\s*\/?>\s*){2,}/i', '<br>', $content);
        // Remove empty paragraphs
        $content = preg_replace('/<p>\s*(<br\s*\/?>|&nbsp;)*\s*<\/p>/i', '', $content);

        return trim($content);
    }

    /**
     * Scope: Only products that are marked as in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('is_stock', true)->where('quantity', '>', 0);
    }

    /**
     * Scope: Products added by a specific admin/user.
     */
    public function scopeByAddedBy($query, $userId)
    {
        return $query->where('added_by', $userId);
    }
}
