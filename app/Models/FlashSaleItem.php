<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}