<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
        $history = $this->histories->where('status_id', $id)->count();
        if($history>0){
            return true;
        }else{
            return false;
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Models\PowerCompany', 'company_id');
    }

}
