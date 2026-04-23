<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Important: Use the exact names from your migration
    protected $fillable = [
        'user_id',
        'invoice',
        'cupon_id',
        'shipping_address_id',
        'billing_address_id',
        'type',
        'payment_option',
        'image',
        'custom',
        'reason_id',
        'remark',
        'is_agree_cancel',
        'phone',
        'meter_no',
        'company_id',
        'sub_total',  // Matches your schema
        'total',      // Matches your schema
        'grand_total', // Matches your schema
        'status'
    ];

    public function items()
    {
        return $this->hasMany(Orderitem::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Deleted User',
            'phone' => 'N/A'
        ]);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function cupon()
    {
        return $this->belongsTo(Cupon::class, 'cupon_id');
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    public function company()
    {
        return $this->belongsTo(PowerCompany::class, 'company_id');
    }

    /**
     * Relationship: An order has many history logs
     */
    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id')->latest('date_time');
    }

    /**
     * Helper to check if a specific status has been reached in history
     */
    public function isActiveHistory($statusId)
    {
        return $this->history()->where('status_id', $statusId)->exists();
    }

    /*
        * Check if the order is in a final state (Delivered or Canceled)
    */
    public function isFinalized()
    {
        // status 3 = Delivered, 4 = Canceled
        return in_array($this->status, [3, 4]);
    }
}
