<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketerWithdraw extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'amount',
        'method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'amount' => 'integer',
    ];

    /**
     * Scope a query to only include withdrawals from the current month.
     * 
     * Usage: MarketerWithdraw::currentMonth()->get();
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }

    /**
     * Scope a query to only include withdrawals from a specific date.
     */
    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }
}
