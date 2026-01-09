<?php

namespace App\Livewire\Frontend\Electricity;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use App\Models\PowerCompany;
use App\Models\WalletPurchase;
use App\Models\ReferPurchase;
use App\Notifications\OrderRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    // State properties
    public $step = 1; // 1: Company List, 2: Form
    public $selectedCompany;

    // Form fields
    public $company_id;
    public $meter_no;
    public $phone;
    public $amount;
    public $payment_option = 'cash';

    public function selectCompany($id)
    {
        if (!Auth::check()) {
            $this->dispatch('openLoginModal'); // Trigger your login modal
            return;
        }

        $this->selectedCompany = PowerCompany::find($id);
        $this->company_id = $id;
        $this->step = 2;
    }

    public function goBack()
    {
        $this->reset(['step', 'selectedCompany', 'company_id', 'meter_no', 'phone', 'amount', 'payment_option']);
    }

    public function store()
    {
        $this->validate([
            'meter_no' => 'required',
            'phone' => 'required',
            'amount' => 'required|numeric|min:10',
            'payment_option' => 'required',
        ]);

        $user = User::find(Auth::user()->id);
        $grand_total = $this->amount;

        // Balance Check for Wallet/Refer
        if ($this->payment_option == 'wallet' && $user->wallet_balance < $grand_total) {
            $this->addError('payment_option', 'Insufficient wallet balance.');
            return;
        }
        if ($this->payment_option == 'reffer' && $user->ref_balance < $grand_total) {
            $this->addError('payment_option', 'Insufficient referral balance.');
            return;
        }

        // 1. Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'invoice' => time() . rand(11111, 99999),
            'type' => 'electricity',
            'company_id' => $this->company_id,
            'phone' => $this->phone,
            'meter_no' => $this->meter_no,
            'payment_option' => $this->payment_option,
            'sub_total' => $grand_total,
            'total' => $grand_total,
            'grand_total' => $grand_total,
        ]);

        // 2. Handle Wallet Payment
        if ($this->payment_option == 'wallet') {
            $user->decrement('wallet_balance', $grand_total);
            WalletPurchase::create([
                'user_id' => $user->id,
                'date' => Carbon::today()->toDateString(),
                'order_id' => $order->id,
                'amount' => $grand_total,
            ]);
        }

        // 3. Handle Refer Payment
        if ($this->payment_option == 'reffer') {
            $user->decrement('ref_balance', $grand_total);
            ReferPurchase::create([
                'user_id' => $user->id,
                'date' => Carbon::today()->toDateString(),
                'order_id' => $order->id,
                'amount' => $grand_total,
            ]);
        }

        // 4. Notifications
        $admins = Admin::all();
        $data = [
            'user_id' => $user->id,
            'order_id' => $order->id,
            'name' => $user->name,
        ];

        foreach ($admins as $admin) {
            $admin->notify(new OrderRequest($data));
        }

        session()->flash('success', 'Order confirmed successfully!');
        return redirect()->route('order.complete');
    }

    public function render()
    {
        return view('livewire.frontend.electricity.index', [
            'companies' => PowerCompany::orderBy('id', 'DESC')->get()
        ]);
    }
}
