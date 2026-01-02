<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeveloperPercentage extends Model
{
    protected $fillable = [
        'date',
        'order_id',
        'amount',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
