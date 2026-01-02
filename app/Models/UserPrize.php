<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrize extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function prize()
    {
    	return $this->belongsTo('App\Models\Prize', 'prize_id');
    }
}
