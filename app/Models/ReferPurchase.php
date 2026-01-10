<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferPurchase extends Model
{
	protected $fillable = [
    	'user_id',
        'date',
        'order_id',
        'amount',
    ];
    
    public function order()
    {
    	return $this->belongsTo(Order::class);
    }
}
