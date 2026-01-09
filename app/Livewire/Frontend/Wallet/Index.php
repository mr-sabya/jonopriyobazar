<?php

namespace App\Livewire\Frontend\Wallet;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Notifications\WalletApply;
use App\Notifications\ApplyWalletPackage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $n_id_front;
    public $n_id_back;
    public $showApplyForm = false;

    public function mount()
    {
        $this->checkWalletExpiration();
    }

    public function checkWalletExpiration()
    {
        $user = User::find(Auth::id());
        $active_package = CustomerWallet::where('user_id', $user->id)->where('status', 1)->first();

        if ($active_package && $active_package->valid_to < Carbon::now()) {
            $user->is_expired = 1;
            $user->save();
        }
    }

    public function toggleApplyForm()
    {
        $this->showApplyForm = !$this->showApplyForm;
    }

    public function submitWalletRequest()
    {
        $user = User::find(Auth::id());

        // Validation logic from controller
        $rules = [];
        if (!$user->n_id_front || !$user->n_id_back) {
            $rules = [
                'n_id_front' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
                'n_id_back' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
            ];
        }
        $this->validate($rules);

        // Handle File Uploads
        if ($this->n_id_front) {
            $filenameFront = time() . '-' . str_replace(' ', '_', $user->name) . '-nid-front.' . $this->n_id_front->getClientOriginalExtension();
            $this->n_id_front->storeAs('images', $filenameFront, 'public_uploads');
            $user->n_id_front = $filenameFront;
        }

        if ($this->n_id_back) {
            $filenameBack = time() . '-' . str_replace(' ', '_', $user->name) . '-nid-back.' . $this->n_id_back->getClientOriginalExtension();
            $this->n_id_back->storeAs('images', $filenameBack, 'public_uploads');
            $user->n_id_back = $filenameBack;
        }

        $user->wallet_request = 1;
        $user->request_date = Carbon::now();
        $user->save();

        // Notify Admins
        $admins = Admin::all();
        $data = ['user_id' => $user->id, 'name' => $user->name];
        foreach ($admins as $admin) {
            $admin->notify(new WalletApply($data));
        }

        session()->flash('success', 'Thank you for your request. We will contact you soon!');
        $this->showApplyForm = false;
    }

    public function applyPackage($id)
    {
        $package = Walletpackage::findOrFail($id);

        $wallet = new CustomerWallet;
        $wallet->user_id = Auth::id();
        $wallet->package_id = $package->id;
        $wallet->is_apply = 1;
        $wallet->save();

        // Notify Admins
        $admins = Admin::all();
        $data = [
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'package' => $package,
        ];
        foreach ($admins as $admin) {
            $admin->notify(new ApplyWalletPackage($data));
        }

        session()->flash('success', 'Successfully applied for ' . $package->name);
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.frontend.wallet.index', [
            'packages' => Walletpackage::orderBy('id', 'ASC')->get(),
            'active_package' => CustomerWallet::where('user_id', $user->id)->where('status', 1)->first(),
            'user' => $user
        ]);
    }
}
