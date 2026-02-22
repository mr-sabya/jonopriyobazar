<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{

    // fillable fields
    protected $fillable = [
        'order_id',
        'product_id',   
        'image',
        'quantity',
        'price'
    ];

    public function product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
