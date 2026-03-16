<?php

namespace App\Livewire\Frontend\User\CancelOrder;

use App\Models\Order;
use App\Models\CancelReason;
use App\Models\User;
use App\Models\WalletPurchase;
use App\Models\ReferPurchase;
use App\Models\RefPercentage;
use App\Models\UserPoint;
use App\Models\DeveloperPercentage;
use App\Models\MarketerPercentage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Manage extends Component
{
    public $order;
    public $reasons;

    // Form fields
    public $reason_id;
    public $remark;
    public $is_agree_cancel;

    public function mount($invoice)
    {
        $this->order = Order::where('invoice', $invoice)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($this->order->status >= 2) {
            session()->flash('error', 'Orders already in processing cannot be canceled.');
            return redirect()->route('profile.order.show', $this->order->invoice);
        }

        $this->reasons = CancelReason::all();
    }

    public function submit()
    {
        $this->validate([
            'reason_id' => 'required',
            'is_agree_cancel' => 'required|accepted',
        ], [
            'reason_id.required' => 'Please select a reason for cancellation.',
            'is_agree_cancel.accepted' => 'You must agree to the terms.',
        ]);

        DB::transaction(function () {
            $user = User::find(Auth::id());
            $order = $this->order;

            // 1. Update Order Status
            $order->update([
                'reason_id' => $this->reason_id,
                'remark' => $this->remark,
                'is_agree_cancel' => $this->is_agree_cancel,
                'status' => 4, // Canceled
            ]);

            // 2. Handle Wallet Refund
            if ($order->payment_option == 'wallet') {
                $purchase = WalletPurchase::where('order_id', $order->id)->first();
                if ($purchase) {
                    $user->increment('wallet_balance', $purchase->amount);
                    $purchase->delete();
                }
            }

            // 3. Handle Refer Balance Refund
            if ($order->payment_option == 'refer') {
                $purchase = ReferPurchase::where('order_id', $order->id)->first();
                if ($purchase) {
                    $user->increment('ref_balance', $purchase->amount);
                    $purchase->delete();
                }
            }

            // 4. Remove Refer Commission from Leader
            $refer = RefPercentage::where('order_id', $order->id)->first();
            if ($refer) {
                $leader = User::find($refer->user_id);
                if ($leader) {
                    $leader->decrement('ref_balance', $refer->amount);
                }
                $refer->delete();
            }

            // 5. Deduct User Points
            $point = UserPoint::where('order_id', $order->id)->first();
            if ($point) {
                $user->decrement('point', $point->point);
                $point->delete();
            }

            // 6. Cleanup Percentages
            DeveloperPercentage::where('order_id', $order->id)->delete();
            MarketerPercentage::where('order_id', $order->id)->delete();
        });

        return $this->redirect(route('user.order.cencel.success'), navigate:true);
    }

    public function render()
    {
        return view('livewire.frontend.user.cancel-order.manage');
    }
}
