<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packeage extends Model
{
    public function p_status()
    {
        return $this->belongsTo('App\Models\PackageStatus', 'status');
    }


    public function items()
    {
        return $this->hasMany('App\Models\PackageItem', 'package_id');
    }
}