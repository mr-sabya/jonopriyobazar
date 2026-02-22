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
        return $this->hasMany('App\Models\Orderitem', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo('App\Models\Address', 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo('App\Models\Address', 'billing_address_id');
    }

    public function cupon()
    {
        return $this->belongsTo('App\Models\Cupon', 'cupon_id');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\OrderHistory', 'order_id');
    }

    public function isActiveHistory($id)
    {
        return $this->histories->where('status_id', $id)->count() > 0;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\PowerCompany', 'company_id');
    }
}
