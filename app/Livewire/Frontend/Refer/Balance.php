<?php

namespace App\Livewire\Frontend\Refer;

use App\Models\Withdraw;
use App\Models\RefPercentage;
use App\Models\ReferPurchase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Balance extends Component
{
    use WithPagination;

    public $searchBalance = '', $searchPurchase = '', $searchWithdraw = '';
    public $sortField = 'date', $sortDirection = 'desc';

    // Withdraw Form
    public $withdraw_amount;

    protected $paginationTheme = 'bootstrap';

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function storeWithdraw()
    {
        $this->validate([
            'withdraw_amount' => 'required|numeric|min:100|max:' . Auth::user()->ref_balance,
        ]);

        Withdraw::create([
            'user_id' => Auth::id(),
            'amount' => $this->withdraw_amount,
            'status' => 0, // Pending
        ]);

        $this->reset('withdraw_amount');
        $this->dispatch('close-modal');
        session()->flash('success', 'Withdraw request submitted successfully!');
    }

    public function render()
    {
        $uid = Auth::id();

        $balances = RefPercentage::with('order')->where('user_id', $uid)
            ->where(fn($q) => $q->where('date', 'like', '%' . $this->searchBalance . '%')->orWhereHas('order', fn($o) => $o->where('invoice', 'like', '%' . $this->searchBalance . '%')))
            ->orderBy($this->sortField, $this->sortDirection)->paginate(10, ['*'], 'balancePage');

        $purchases = ReferPurchase::with('order')->where('user_id', $uid)
            ->where(fn($q) => $q->where('date', 'like', '%' . $this->searchPurchase . '%')->orWhereHas('order', fn($o) => $o->where('invoice', 'like', '%' . $this->searchPurchase . '%')))
            ->orderBy($this->sortField, $this->sortDirection)->paginate(10, ['*'], 'purchasePage');

        $withdraws = Withdraw::where('user_id', $uid)
            ->where('amount', 'like', '%' . $this->searchWithdraw . '%')
            ->orderBy('created_at', 'desc')->paginate(10, ['*'], 'withdrawPage');

        return view('livewire.frontend.refer.balance', compact('balances', 'purchases', 'withdraws'));
    }
}
