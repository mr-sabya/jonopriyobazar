<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    public function status()
    {
    	return $this->belongsTo('App\Models\DeliveryStatus', 'status_id');
    }
}
