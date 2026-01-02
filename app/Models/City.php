<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function thana()
    {
    	return $this->belongsTo('App\Models\Thana', 'thana_id');
    }

}
