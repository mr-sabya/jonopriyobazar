<?php

namespace App\Livewire\Backend\CustomOrder;

use App\Models\{Order, ReferPurchase, User, WalletPurchase};
use App\Enums\{OrderStatus, PaymentOption};
use App\Traits\ManagesOrderStatuses; // Import the Trait
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    use ManagesOrderStatuses; // Logic for Rewards, History, and Refunds is here

    public $order;
    public $total;
    public $delivery_charge;
    public $grand_total;
    public $payment_option;

    /**
     * Initialize the component
     */
    public function mount($id)
    {
        $this->order = Order::with([
            'customer',
            'shippingAddress.city',
            'shippingAddress.thana',
            'shippingAddress.district',
            'billingAddress',
            'history.status'
        ])->findOrFail($id);

        $this->total = $this->order->total;
        $this->delivery_charge = $this->order->shippingAddress['city']['delivery_charge'] ?? 0;
        $this->grand_total = $this->order->grand_total;

        // Use the .value property of the Enum for the wire:model select
        $this->payment_option = $this->order->payment_option->value;
    }

    /**
     * Auto-calculate grand total when sub-total changes
     */
    public function updatedTotal($value)
    {
        $this->grand_total = (floatval($value) + floatval($this->delivery_charge));
    }

    /**
     * Finalize Pricing and handle Wallet/Refer balance deduction
     */
    public function saveFinancials()
    {
        $user = User::find($this->order->user_id);
        $paymentEnum = PaymentOption::from($this->payment_option);

        // Handle Balance Deductions if Payment is via Wallet/Refer
        if ($paymentEnum === PaymentOption::WALLET || $paymentEnum === PaymentOption::REFER) {

            // Logic for Wallet Purchase
            if ($paymentEnum === PaymentOption::WALLET) {
                $alreadyCharged = WalletPurchase::where('order_id', $this->order->id)->exists();
                if (!$alreadyCharged) {
                    if ($user->wallet_balance < $this->grand_total) {
                        $this->dispatch('swal', ['type' => 'error', 'message' => "Insufficient Wallet Balance!"]);
                        return;
                    }
                    $user->decrement('wallet_balance', $this->grand_total);
                    WalletPurchase::create([
                        'user_id' => $user->id,
                        'date' => Carbon::today(),
                        'order_id' => $this->order->id,
                        'amount' => $this->grand_total,
                    ]);
                }
            }

            // Logic for Refer Purchase
            if ($paymentEnum === PaymentOption::REFER) {
                $alreadyCharged = ReferPurchase::where('order_id', $this->order->id)->exists();
                if (!$alreadyCharged) {
                    if ($user->ref_balance < $this->grand_total) {
                        $this->dispatch('swal', ['type' => 'error', 'message' => "Insufficient Refer Wallet Balance!"]);
                        return;
                    }
                    $user->decrement('ref_balance', $this->grand_total);
                    ReferPurchase::create([
                        'user_id' => $user->id,
                        'date' => Carbon::today(),
                        'order_id' => $this->order->id,
                        'amount' => $this->grand_total,
                    ]);
                }
            }
        }

        $this->order->update([
            'sub_total' => $this->total,
            'total' => $this->total,
            'grand_total' => $this->grand_total,
            'payment_option' => $paymentEnum
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'Financials updated and payment processed!']);
        $this->order->refresh();
    }

    /**
     * Update Order Status (Delegated to Trait)
     */
    public function updateStatus($statusValue)
    {
        // This method from the Trait handles:
        // 1. History Log
        // 2. Status Update
        // 3. Rewards Points, Commissions (on Delivery)
        // 4. Refunds and Commission Reversals (on Cancel)
        $this->updateOrderStatus($this->order->id, $statusValue);
    }

    public function render()
    {
        return view('livewire.backend.custom-order.show');
    }
}
