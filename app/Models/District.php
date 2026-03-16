<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all Thanas (Upazilas) associated with this district.
     */
    public function thanas(): HasMany
    {
        return $this->hasMany(Thana::class, 'district_id');
    }

    /**
     * Get all Cities/Areas associated with this district through Thanas.
     * District -> Thana -> City
     */
    public function cities(): HasManyThrough
    {
        return $this->hasManyThrough(City::class, Thana::class, 'district_id', 'thana_id');
    }

    /**
     * Get all addresses registered in this district.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'district_id');
    }

    /**
     * Scope a query to sort districts alphabetically.
     * Usage: District::alphabetical()->get();
     */
    public function scopeAlphabetical($query)
    {
        return $query->orderBy('name', 'ASC');
    }
}
