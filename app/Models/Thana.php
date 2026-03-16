<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thana extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'district_id',
	];

	/**
	 * The attributes that should be cast.
	 */
	protected $casts = [
		'district_id' => 'integer',
	];

	/**
	 * Get the District that this Thana belongs to.
	 */
	public function district(): BelongsTo
	{
		return $this->belongsTo(District::class, 'district_id');
	}

	/**
	 * Get all Cities/Areas associated with this Thana.
	 */
	public function cities(): HasMany
	{
		return $this->hasMany(City::class, 'thana_id');
	}

	/**
	 * Alias for cities (keeping your existing method name for backward compatibility)
	 */
	public function city()
	{
		return $this->cities();
	}

	/**
	 * Get all addresses registered in this Thana.
	 */
	public function addresses(): HasMany
	{
		return $this->hasMany(Address::class, 'thana_id');
	}

	/**
	 * Scope a query to sort Thanas alphabetically.
	 * Usage: Thana::alphabetical()->get();
	 */
	public function scopeAlphabetical($query)
	{
		return $query->orderBy('name', 'ASC');
	}
}
