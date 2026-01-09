<?php

namespace App\Livewire\Frontend\Wallet;

use App\Models\Payments;
use App\Models\WalletPurchase;
use App\Models\CustomerWallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    // Search & Sort Properties
    public $searchPurchase = '';
    public $searchPayment = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearchPurchase()
    {
        $this->resetPage();
    }
    public function updatingSearchPayment()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user_id = Auth::id();

        // 1. Query Purchases with Search & Sort
        $purchases = WalletPurchase::with('order')
            ->where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('date', 'like', '%' . $this->searchPurchase . '%')
                    ->orWhereHas('order', function ($q) {
                        $q->where('invoice', 'like', '%' . $this->searchPurchase . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10, ['*'], 'purchasePage');

        // 2. Query Payments with Search & Sort
        $pays = Payments::where('user_id', $user_id)
            ->where('amount', '>', 0)
            ->where(function ($query) {
                $query->where('date', 'like', '%' . $this->searchPayment . '%')
                    ->orWhere('amount', 'like', '%' . $this->searchPayment . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10, ['*'], 'paymentPage');

        $active_package = CustomerWallet::where('user_id', $user_id)->where('status', 1)->first();

        return view('livewire.frontend.wallet.show', [
            'purchases' => $purchases,
            'pays' => $pays,
            'active_package' => $active_package
        ]);
    }
}
