<?php

namespace App\Livewire\Backend\Order;

use App\Models\{Order, User, OrderHistory, DeliveryStatus, UserPoint, ReferPurchase, WalletPurchase, RefPercentage, MarketerPercentage, DeveloperPercentage};
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Show extends Component
{
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function updateStatus($statusId)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($this->orderId);
            $status = DeliveryStatus::findOrFail($statusId);

            // Safety Checks
            if ($order->isFinalized() || $order->isActiveHistory($statusId)) {
                return session()->flash('error', 'Update not allowed.');
            }

            // 1. Log History
            OrderHistory::create([
                'order_id' => $order->id,
                'status_id' => $statusId,
                'date_time' => Carbon::now()
            ]);

            // 2. Map Status to Order Table
            $map = ['approved' => 1, 'packed' => 2, 'delivered' => 3, 'canceled' => 4];
            if (isset($map[$status->slug])) {
                $order->status = $map[$status->slug];
                $order->save();
            }

            // 3. Reversal Logic if Canceled
            if ($status->slug == 'canceled') {
                $this->handleCancellation($order);
            }

            DB::commit();
            session()->flash('success', 'Order status updated to ' . $status->name);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    private function handleCancellation($order)
    {
        $user = User::find($order->user_id);
        if (!$user) return;

        // Refund Balances
        if ($order->payment_option == 'wallet') {
            $p = WalletPurchase::where('order_id', $order->id)->first();
            if ($p) {
                $user->increment('wallet_balance', $p->amount);
                $p->delete();
            }
        }
        if ($order->payment_option == 'refer') {
            $p = ReferPurchase::where('order_id', $order->id)->first();
            if ($p) {
                $user->increment('ref_balance', $p->amount);
                $p->delete();
            }
        }

        // Revert Leader Percentages
        $ref = RefPercentage::where('order_id', $order->id)->first();
        if ($ref) {
            $leader = User::find($ref->user_id);
            if ($leader) $leader->decrement('ref_balance', $ref->amount);
            $ref->delete();
        }

        // Deduct Points
        $pt = UserPoint::where('order_id', $order->id)->first();
        if ($pt) {
            $user->decrement('point', $pt->point);
            $pt->delete();
        }

        // Remove Percentages
        DeveloperPercentage::where('order_id', $order->id)->delete();
        MarketerPercentage::where('order_id', $order->id)->delete();
    }

    public function render()
    {
        return view('livewire.backend.order.show', [
            'order' => Order::with(['items.product', 'customer', 'shippingAddress.city', 'shippingAddress.thana', 'shippingAddress.district', 'billingAddress', 'history.status', 'cupon'])->findOrFail($this->orderId),
            'statuses' => DeliveryStatus::orderBy('id', 'ASC')->get()
        ]);
    }
}
