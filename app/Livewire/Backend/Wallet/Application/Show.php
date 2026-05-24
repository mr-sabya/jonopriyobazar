<?php

namespace App\Livewire\Backend\Wallet\Application;

use App\Models\User;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Notifications\ApproveWalletPackage;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $user;
    public $package_id; // For the modal/assign form

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
    }

    public function approve($id)
    {
        $package = CustomerWallet::with('package')->findOrFail($id);

        // Deactivate all previous packages
        CustomerWallet::where('user_id', $this->user->id)->update(['status' => 0]);

        $package->valid_from = Carbon::now();
        $package->valid_to = Carbon::now()->addDays($package->package->validate);
        $package->status = 1;
        $package->save();

        // Update User
        $this->user->update([
            'wallet_balance' => $package->package->amount,
            'wallet_package_id' => $package->package->id
        ]);

        $data = [
            'user_id' => $this->user->id,
            'info' => 'Your wallet package request is Approved!',
        ];
        $this->user->notify(new ApproveWalletPackage($data));

        session()->flash('success', 'Package is approved');
    }

    public function assign()
    {
        $this->validate(['package_id' => 'required']);

        $package = Walletpackage::findOrFail($this->package_id);

        CustomerWallet::where('user_id', $this->user->id)->update(['status' => 0]);

        $wallet = new CustomerWallet();
        $wallet->user_id = $this->user->id;
        $wallet->package_id = $package->id;
        $wallet->valid_from = Carbon::now();
        $wallet->valid_to = Carbon::now()->addDays($package->validate);
        $wallet->is_apply = 1;
        $wallet->status = 1;
        $wallet->save();

        $this->user->update([
            'wallet_balance' => $package->amount,
            'wallet_package_id' => $package->id
        ]);

        $this->user->notify(new ApproveWalletPackage([
            'user_id' => $this->user->id,
            'info' => 'Your wallet package request is Approved!',
        ]));

        $this->dispatch('close-modal');
        session()->flash('success', 'Credit Wallet Package has been assigned');
    }

    public function delete($id)
    {
        $package = CustomerWallet::findOrFail($id);
        if ($package->status == 1) {
            session()->flash('error', 'This package is already active for the user');
        } else {
            $package->delete();
            session()->flash('success', 'Package Request has been deleted');
        }
    }

    public function render()
    {
        return view('livewire.backend.wallet.application.show', [
            'packages' => CustomerWallet::where('user_id', $this->user->id)->latest()->get(),
            'packs' => Walletpackage::all()
        ]);
    }
}
