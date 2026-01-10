<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * Matches the 'addresses' table schema exactly.
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'street',
        'district_id',
        'thana_id',
        'city_id',
        'post_code',
        'type',
        'is_shipping',
        'is_billing',
    ];

    /**
     * Relationship with the User who owns this address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with District.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * Relationship with Thana.
     */
    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id');
    }

    /**
     * Relationship with City.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Accessor to get a formatted full address string.
     * Usage in Blade: $address->full_address
     */
    public function getFullAddressAttribute()
    {
        return "{$this->street}, " .
            ($this->city ? $this->city->name . " - " : "") .
            "{$this->post_code}, " .
            ($this->thana ? $this->thana->name . ", " : "") .
            ($this->district ? $this->district->name : "");
    }
}
