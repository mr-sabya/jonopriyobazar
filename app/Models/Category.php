<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function sub()
    {
        return $this->hasMany('App\Models\Category', 'p_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'p_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
