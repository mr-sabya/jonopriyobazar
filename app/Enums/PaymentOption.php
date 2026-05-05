<?php

namespace App\Enums;

use App\Models\User;

enum PaymentOption: string
{
    case CASH = 'cash';
    case WALLET = 'wallet';
    case REFER = 'refer';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash On Delivery',
            self::WALLET => 'Credit Wallet',
            self::REFER => 'Refer Wallet',
        };
    }

    // Add this for your table display
    public function shortLabel(): string
    {
        return match ($this) {
            self::CASH => 'COD',
            self::WALLET => 'Wallet',
            self::REFER => 'Refer',
        };
    }

    /**
     * Check if the specific feature is enabled for the user
     */
    public function isEnabled(User $user): bool
    {
        return match ($this) {
            self::CASH => true,
            self::WALLET => $user->is_wallet == 1,
            self::REFER => $user->is_percentage == 1,
        };
    }

    /**
     * Check if the user has enough balance and isn't restricted
     */
    public function canPay(User $user, float $amount): bool
    {
        return match ($this) {
            self::CASH => true,
            self::WALLET => $user->wallet_balance >= $amount && !$user->is_hold,
            self::REFER => $user->ref_balance >= $amount,
        };
    }

    /**
     * Get the current balance of the user for this payment type
     */
    public function getBalance(User $user): ?float
    {
        return match ($this) {
            self::CASH => null,
            self::WALLET => $user->wallet_balance,
            self::REFER => $user->ref_balance,
        };
    }
}
