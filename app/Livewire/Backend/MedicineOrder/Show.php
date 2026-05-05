<?php

namespace App\Livewire\Backend\MedicineOrder;

use App\Models\{Order, User, WalletPurchase, ReferPurchase};
use App\Enums\{OrderStatus, PaymentOption};
use App\Traits\ManagesOrderStatuses;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    use ManagesOrderStatuses;

    public $order;
    public $total;
    public $delivery_charge;
    public $grand_total;
    public $payment_option;

    public function mount($id)
    {
        $this->order = Order::with(['customer', 'shippingAddress.city', 'shippingAddress.thana', 'shippingAddress.district', 'billingAddress', 'history.status'])->findOrFail($id);

        $this->total = $this->order->total;
        $this->delivery_charge = $this->order->shippingAddress['city']['delivery_charge'] ?? 0;
        $this->grand_total = $this->order->grand_total;
        $this->payment_option = $this->order->payment_option->value;
    }

    public function updatedTotal($value)
    {
        $this->grand_total = (floatval($value) + floatval($this->delivery_charge));
    }

    public function saveFinancials()
    {
        $user = User::find($this->order->user_id);
        $paymentEnum = PaymentOption::from($this->payment_option);

        // Check and Charge logic for Wallet/Refer if not already charged
        if ($paymentEnum === PaymentOption::WALLET) {
            if (!WalletPurchase::where('order_id', $this->order->id)->exists()) {
                if ($user->wallet_balance < $this->grand_total) {
                    $this->dispatch('swal', ['type' => 'error', 'message' => "Low Wallet Balance!"]);
                    return;
                }
                $user->decrement('wallet_balance', $this->grand_total);
                WalletPurchase::create(['user_id' => $user->id, 'date' => now(), 'order_id' => $this->order->id, 'amount' => $this->grand_total]);
            }
        }

        if ($paymentEnum === PaymentOption::REFER) {
            if (!ReferPurchase::where('order_id', $this->order->id)->exists()) {
                if ($user->ref_balance < $this->grand_total) {
                    $this->dispatch('swal', ['type' => 'error', 'message' => "Low Refer Balance!"]);
                    return;
                }
                $user->decrement('ref_balance', $this->grand_total);
                ReferPurchase::create(['user_id' => $user->id, 'date' => now(), 'order_id' => $this->order->id, 'amount' => $this->grand_total]);
            }
        }

        $this->order->update([
            'sub_total' => $this->total,
            'total' => $this->total,
            'grand_total' => $this->grand_total,
            'payment_option' => $paymentEnum
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'Financials updated!']);
        $this->order->refresh();
    }

    public function updateStatus($statusValue)
    {
        $this->updateOrderStatus($this->order->id, $statusValue);
    }

    public function render()
    {
        return view('livewire.backend.medicine-order.show');
    }
}
