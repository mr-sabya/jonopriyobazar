<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prize extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'prize',
        'point',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'point' => 'integer',
    ];

    /**
     * Relationship: A prize can have many point withdrawal requests.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Pointwithdraw::class, 'prize_id');
    }

    /**
     * Scope a query to only include prizes a user can afford.
     * Usage: Prize::affordableBy(Auth::user()->point)->get();
     */
    public function scopeAffordableBy($query, $userPoints)
    {
        return $query->where('point', '<=', $userPoints);
    }
}
