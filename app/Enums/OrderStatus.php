<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING    = 0;
    case RECEIVED   = 1; // "Approved"
    case PACKED     = 2; // "Packed"
    case PROCESSING = 3; // "Handover to Delivery Man"
    case DELIVERED  = 4; // "Delivered"
    case CANCELED   = 5; // "Canceled"

    /**
     * Get the human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING    => 'Pending',
            self::RECEIVED   => 'Approved',
            self::PACKED     => 'Packed',
            self::PROCESSING => 'Processing',
            self::DELIVERED  => 'Delivered',
            self::CANCELED   => 'Canceled',
        };
    }

    /**
     * Get the Bootstrap color class suffix
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING    => 'warning',
            self::RECEIVED   => 'primary',
            self::PACKED     => 'info',
            self::PROCESSING => 'secondary', // Using secondary for processing
            self::DELIVERED  => 'success',
            self::CANCELED   => 'danger',
        };
    }

    /**
     * Generate the HTML Badge
     */
    public function badge(): string
    {
        $color = $this->color();
        $label = $this->label();

        // Using your specific Soft UI design pattern
        return "<span class='badge bg-{$color}-soft text-{$color} border border-{$color} rounded-pill px-3'>
                    <i class='fas fa-circle me-1 small' style='font-size: 8px;'></i> {$label}
                </span>";
    }

    /**
     * Check if the order is in a final state (cannot be edited further)
     */
    public function isFinalized(): bool
    {
        return in_array($this, [self::DELIVERED, self::CANCELED]);
    }
}
