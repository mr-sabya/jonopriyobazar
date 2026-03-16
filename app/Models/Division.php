<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Division extends Model
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
     * Get all Districts associated with this division.
     * 
     * Note: This assumes your 'districts' table has a 'division_id' column.
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'division_id');
    }

    /**
     * Get all Thanas (Upazilas) associated with this division through Districts.
     * Division -> District -> Thana
     */
    public function thanas(): HasManyThrough
    {
        return $this->hasManyThrough(Thana::class, District::class, 'division_id', 'district_id');
    }

    /**
     * Get all addresses registered within this division.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'division_id');
    }

    /**
     * Scope a query to sort divisions alphabetically.
     * Usage: Division::alphabetical()->get();
     */
    public function scopeAlphabetical($query)
    {
        return $query->orderBy('name', 'ASC');
    }
}
