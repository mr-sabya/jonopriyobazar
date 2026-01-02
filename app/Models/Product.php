<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
        'name',
        'slug',
        'quantity',
        'sale_price',
        'actual_price',
        'off',
        'is_percentage',
        'point',
        'image',
        'description',
        'added_by'
    ];

	public function categories()
	{
		return $this->belongsToMany('App\Models\Category');
	}

	
}
