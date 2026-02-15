<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Accessor to get subtotal for a specific row
     * Usage: $cartItem->subtotal
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Improved static method to add items to cart
     */
    public static function add($productId, $quantity = 1)
    {
        // 1. Ensure User is Logged In (Or handle guest via session if needed)
        if (!Auth::check()) {
            // Optional: You can redirect or throw an error here
            return false;
        }

        $userId = Auth::id();
        $product = Product::find($productId);

        // 2. Validate Product exists and has stock
        if (!$product) return false;

        if ($product->quantity < $quantity) {
            // You can dispatch a browser event here or return a specific message
            return 'out_of_stock';
        }

        // 3. Check if the item already exists in this user's cart
        $cartItem = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // 4. Update quantity if it exists, but check stock again
            $newQuantity = $cartItem->quantity + $quantity;

            if ($product->quantity < $newQuantity) {
                return 'out_of_stock';
            }

            $cartItem->increment('quantity', $quantity);
            // Optional: Update price in case it changed since they first added it
            $cartItem->update(['price' => $product->sale_price]);

            return $cartItem;
        }

        // 5. Create new cart entry using sale_price
        return self::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => $quantity,
            'price'      => $product->sale_price,
        ]);
    }

    /**
     * Helper to get total count for the current user
     */
    public static function totalItems()
    {
        return self::where('user_id', Auth::id())->sum('quantity');
    }

    /**
     * Helper to get total amount for the current user
     */
    public static function totalAmount()
    {
        $items = self::where('user_id', Auth::id())->get();
        return $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
