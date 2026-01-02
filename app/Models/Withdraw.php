<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }
}
