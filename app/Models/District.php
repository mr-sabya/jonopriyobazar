<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function thanas()
    {
    	return $this->hasMany('App\Models\Thana', 'district_id');
    }
}
