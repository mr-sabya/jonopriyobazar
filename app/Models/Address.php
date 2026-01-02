<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
    }

    public function thana()
    {
        return $this->belongsTo('App\Models\Thana', 'thana_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function add_cat()
    {
        return $this->belongsTo('App\Models\AddressCategory', 'address_category_id');
    }

}