<?php

namespace App\Livewire\Backend\Wallet\WalletUser;

use App\Models\User;
use App\Models\Walletpackage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filter Properties
    public $search = '';
    public $status = '';      // User Status (Active/Hold/Deactive)
    public $expiration = '';  // Expired/Active
    public $hold_status = ''; // Hold/Active
    public $package_id = '';  // Filter by specific package

    /**
     * Reset pagination when any filter changes
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStatus()
    {
        $this->resetPage();
    }
    public function updatedExpiration()
    {
        $this->resetPage();
    }
    public function updatedHoldStatus()
    {
        $this->resetPage();
    }
    public function updatedPackageId()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'expiration', 'hold_status', 'package_id']);
    }

    public function render()
    {
        // 1. AUTO-EXPIRE UPDATE logic (runs first to keep data fresh)
        User::where('is_wallet', 1)
            ->where('is_expired', 0)
            ->whereHas('userPackages', function ($query) {
                $query->where('status', 1)->where('valid_to', '<', now());
            })
            ->update(['is_expired' => 1]);

        // 2. Build Query
        $query = User::query()->where('is_wallet', 1);

        // Search Filter
        $query->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            });
        });

        // User Status Filter (1=Active, 2=Hold, 0=Deactive)
        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        // Expiration Filter
        if ($this->expiration !== '') {
            $query->where('is_expired', $this->expiration);
        }

        // Hold Status Filter
        if ($this->hold_status !== '') {
            $query->where('is_hold', $this->hold_status);
        }

        // Package Filter
        if ($this->package_id !== '') {
            $query->where('wallet_package_id', $this->package_id);
        }

        $users = $query->with(['activePackage', 'userPackages' => fn($q) => $q->where('status', 1)])
            ->withSum('walletPurchase as total_purchase', 'amount')
            ->withSum('walletPay as total_pay', 'amount')
            ->latest()
            ->paginate(15);

        return view('livewire.backend.wallet.wallet-user.index', [
            'users' => $users,
            'packages' => Walletpackage::orderBy('amount', 'asc')->get()
        ]);
    }
}
