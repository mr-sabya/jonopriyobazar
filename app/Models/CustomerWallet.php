<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    public function package()
    {
    	return $this->belongsTo('App\Models\Walletpackage', 'package_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }
}
