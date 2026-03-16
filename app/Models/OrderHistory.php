<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'date_time',
        'status_id',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Casting 'date_time' to datetime allows you to use Carbon 
     * methods like format(), diffForHumans(), etc.
     */
    protected $casts = [
        'order_id' => 'integer',
        'date_time' => 'datetime',
        'status_id' => 'integer',
    ];

    /**
     * Get the Order associated with this history log.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the Delivery Status associated with this history log.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(DeliveryStatus::class, 'status_id');
    }
}
