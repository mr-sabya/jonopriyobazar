<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletPurchase extends Model
{
    protected $fillable = [
    	'user_id',
        'date',
        'order_id',
        'amount',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
