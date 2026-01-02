<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
     public function items()
    {
        return $this->hasMany('App\Models\flashSaleItem', 'flash_sale_id');
    }
}