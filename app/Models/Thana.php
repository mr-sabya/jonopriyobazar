<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
	public function district()
	{
		return $this->belongsTo('App\Models\District', 'district_id');
	}

	public function city()
	{
		return $this->hasMany('App\Models\City', 'thana_id');
	}
}