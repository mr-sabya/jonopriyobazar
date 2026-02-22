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
        return $this->belongsTo(User::class, 'user_id');
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

    public function isActiveHistory($id)
    {
        return $this->histories->where('status_id', $id)->count() > 0;
    }

    public function company()
    {
        return $this->belongsTo(PowerCompany::class, 'company_id');
    }
}
