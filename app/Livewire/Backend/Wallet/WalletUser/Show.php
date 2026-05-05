<?php

namespace App\Livewire\Backend\Wallet\WalletUser;

use App\Models\User;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Models\Payments;
use App\Models\WalletPurchase;
use Livewire\Component;
use Carbon\Carbon;

class Show extends Component
{
    public $user;

    // Form Properties
    public $selected_package_id;
    public $extend_date;
    public $extend_package_id;
    public $payment_date;
    public $payment_amount;
    public $delete_target_id;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->payment_date = date('Y-m-d');
    }

    // --- Wallet Status Logic ---
    public function toggleHold()
    {
        $this->user->is_hold = !$this->user->is_hold;
        $this->user->save();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Status Updated']);
    }

    // Inside approvePackage()
    public function approvePackage($id)
    {
        $package = CustomerWallet::findOrFail($id);
        $valid_to = Carbon::now()->addDays($package->package->validate);

        $package->update([
            'status' => 1,
            'valid_from' => Carbon::now(),
            'valid_to' => $valid_to
        ]);

        // Reset User Expiration status
        $this->user->update([
            'wallet_package_id' => $package->package_id,
            'is_expired' => 0 // USER IS NOW ACTIVE
        ]);

        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Package Approved']);
    }

    // Inside extendPackage()
    public function extendPackage()
    {
        CustomerWallet::where('id', $this->extend_package_id)->update([
            'valid_to' => $this->extend_date
        ]);

        // If the new date is in the future, reset the user's expired status
        if (Carbon::parse($this->extend_date) > now()) {
            $this->user->update(['is_expired' => 0]);
        }

        $this->dispatch('close-modal', ['id' => 'extend_modal']);
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Package Extended']);
    }

    public function changePackage()
    {
        $this->validate(['selected_package_id' => 'required']);

        CustomerWallet::create([
            'user_id' => $this->user->id,
            'package_id' => $this->selected_package_id,
            'status' => 0
        ]);

        $this->dispatch('close-modal', ['id' => 'package_modal']);
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Package Applied']);
    }

    public function openExtendModal($id, $currentDate)
    {
        $this->extend_package_id = $id;
        $this->extend_date = $currentDate ? Carbon::parse($currentDate)->format('Y-m-d\TH:i') : '';
        $this->dispatch('open-modal', ['id' => 'extend_modal']);
    }

    // --- Payment Logic ---
    public function addPayment()
    {
        $this->validate([
            'payment_amount' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        Payments::create([
            'user_id' => $this->user->id,
            'amount' => $this->payment_amount,
            'date' => $this->payment_date
        ]);

        $this->user->increment('wallet_balance', $this->payment_amount);
        $this->payment_amount = '';
        $this->dispatch('close-modal', ['id' => 'pay_modal']);
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Payment Added']);
    }

    public function confirmDeletePackage($id)
    {
        $this->delete_target_id = $id;
        $this->dispatch('open-modal', ['id' => 'confirmModal']);
    }

    public function deletePackage()
    {
        CustomerWallet::find($this->delete_target_id)?->delete();
        $this->dispatch('close-modal', ['id' => 'confirmModal']);
        $this->dispatch('swal', ['icon' => 'warning', 'title' => 'Package Deleted']);
    }

    public function render()
    {
        return view('livewire.backend.wallet.wallet-user.show', [
            'packages' => CustomerWallet::with('package')->where('user_id', $this->user->id)->latest()->get(),
            'purchases' => WalletPurchase::with('order')->where('user_id', $this->user->id)->latest()->get(),
            'payments' => Payments::where('user_id', $this->user->id)->latest()->get(),
            'availablePacks' => Walletpackage::all(),
            'totalPurchase' => $this->user->walletPurchase()->sum('amount'),
            'totalPay' => $this->user->walletPay()->sum('amount'),
        ]);
    }
}
