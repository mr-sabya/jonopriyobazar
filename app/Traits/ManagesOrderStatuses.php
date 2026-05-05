<?php

namespace App\Traits;

use App\Models\{Order, User, OrderHistory, WalletPurchase, ReferPurchase, RefPercentage, UserPoint, DeveloperPercentage, MarketerPercentage};
use App\Enums\{OrderStatus, PaymentOption};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * @method void dispatch(string $event, array $data)
 */
trait ManagesOrderStatuses
{
    public function updateOrderStatus($orderId, $statusValue)
    {
        $targetStatus = OrderStatus::from($statusValue);

        DB::beginTransaction();
        try {
            $order = Order::with('items.product')->findOrFail($orderId);
            $user = User::find($order->user_id);

            if (!$user) throw new \Exception("User not found.");
            if ($order->status === $targetStatus) return;

            // 1. Log History
            OrderHistory::create([
                'order_id' => $order->id,
                'status_id' => $targetStatus->value,
                'date_time' => Carbon::now()
            ]);

            // 2. Update Status
            $order->status = $targetStatus;
            $order->save();

            // 3. Status Specific Logic
            if ($targetStatus === OrderStatus::DELIVERED) {
                $this->processDeliveredRewardsAndPayments($order, $user);
            } elseif ($targetStatus === OrderStatus::CANCELED) {
                $this->processCancellationReversal($order, $user);
            }

            DB::commit();

            if (method_exists($this, 'dispatch')) {
                $this->dispatch('swal', ['type' => 'success', 'message' => 'Order status updated to ' . $targetStatus->label()]);
            }

            if (method_exists($this, 'mount')) $this->mount($orderId);
        } catch (\Exception $e) {
            DB::rollBack();
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('swal', ['type' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * DELIVERED LOGIC: Process Payments and Distribute Rewards (Product-based Points)
     */
    private function processDeliveredRewardsAndPayments($order, $user)
    {
        /**
         * ERROR CHECK 1: User Status
         * Check if the user is restricted before processing payments.
         */
        if ($user->is_hold) {
            throw new \Exception("Payment failed: User account is currently on hold.");
        }

        // --- 1. HANDLE PAYMENTS ---
        // We check for PaymentOption Enum types directly.

        // Credit Wallet Payment
        if ($order->payment_option === PaymentOption::WALLET) {
            if (!WalletPurchase::where('order_id', $order->id)->exists()) {
                if ($user->wallet_balance < $order->grand_total) {
                    throw new \Exception("Insufficient Credit Wallet balance. Required: {$order->grand_total}, Available: {$user->wallet_balance}");
                }

                // Atomic decrement to prevent race conditions
                $user->decrement('wallet_balance', $order->grand_total);

                WalletPurchase::create([
                    'user_id'  => $user->id,
                    'date'     => now()->toDateString(),
                    'order_id' => $order->id,
                    'amount'   => $order->grand_total,
                ]);
            }
        }

        // Refer Wallet Payment
        if ($order->payment_option === PaymentOption::REFER) {
            if (!ReferPurchase::where('order_id', $order->id)->exists()) {
                if ($user->ref_balance < $order->grand_total) {
                    throw new \Exception("Insufficient Refer Wallet balance. Required: {$order->grand_total}, Available: {$user->ref_balance}");
                }

                $user->decrement('ref_balance', $order->grand_total);

                ReferPurchase::create([
                    'user_id'  => $user->id,
                    'date'     => now()->toDateString(),
                    'order_id' => $order->id,
                    'amount'   => $order->grand_total,
                ]);
            }
        }

        // --- 2. HANDLE PRODUCT-BASED POINTS ---
        // Check if points were already awarded to prevent double-crediting
        if (!UserPoint::where('order_id', $order->id)->exists()) {
            $totalPointsToGive = 0;

            /**
             * ERROR CHECK 2: Null Product Check
             * If a product was deleted from the database after the order was placed, 
             * $item->product will be null. We must handle this to avoid a crash.
             */
            foreach ($order->items as $item) {
                if ($item->product) {
                    $productPoint = (int)($item->product->point ?? 0);
                    $totalPointsToGive += ($productPoint * $item->quantity);
                }
            }

            if ($totalPointsToGive > 0) {
                UserPoint::create([
                    'user_id'  => $user->id,
                    'order_id' => $order->id,
                    'date'     => now()->toDateString(),
                    'point'    => $totalPointsToGive
                ]);
                $user->increment('point', $totalPointsToGive);
            }
        }

    // --- 3. COMMISSIONS & PERCENTAGES ---

        /**
         * ERROR CHECK 3: Referral Self-Loop
         * Ensure the user isn't their own leader (shouldn't happen, but safety first).
         */
        if ($user->ref_id && $user->referral_id !== $user->id && !RefPercentage::where('order_id', $order->id)->exists()) {
            $leader = User::find($user->referral_id);

            if ($leader) {
                /**
                 * ERROR CHECK 4: Precision Rounding
                 * Financial calculations should be rounded to 2 decimal places 
                 * to avoid floating point errors in the database.
                 */
                $commission = round($order->grand_total * 0.05, 2);

                if ($commission > 0) {
                    RefPercentage::create([
                        'user_id'  => $leader->id,
                        'order_id' => $order->id,
                        'amount'   => $commission
                    ]);
                    $leader->increment('ref_balance', $commission);
                }
            }
        }

    }
    /**
     * CANCELED LOGIC: Refund User and Revert Commissions/Points
     */
    private function processCancellationReversal($order, $user)
    {
        // Refund Payment
        if ($order->payment_option === PaymentOption::WALLET) {
            $p = WalletPurchase::where('order_id', $order->id)->first();
            if ($p) {
                $user->increment('wallet_balance', $p->amount);
                $p->delete();
            }
        }
        if ($order->payment_option === PaymentOption::REFER) {
            $p = ReferPurchase::where('order_id', $order->id)->first();
            if ($p) {
                $user->increment('ref_balance', $p->amount);
                $p->delete();
            }
        }

        // Revert Leader Commission
        $ref = RefPercentage::where('order_id', $order->id)->first();
        if ($ref) {
            $leader = User::find($ref->user_id);
            if ($leader) $leader->decrement('ref_balance', $ref->amount);
            $ref->delete();
        }

        // Revert Points
        $pointRecord = UserPoint::where('order_id', $order->id)->first();
        if ($pointRecord) {
            $user->decrement('point', $pointRecord->point);
            $pointRecord->delete();
        }
    }
}
