<?php

namespace App\Livewire\Backend\Withdraw;

use App\Models\User;
use App\Models\Withdraw;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Mark withdrawal as completed and deduct from user balance
     */
    public function complete($id)
    {
        $withdraw = Withdraw::findOrFail($id);

        // Prevent double processing
        if ($withdraw->status == 1) {
            return;
        }

        DB::transaction(function () use ($withdraw) {
            // 1. Update Withdraw Status
            $withdraw->status = 1;
            $withdraw->save();

            // 2. Deduct from User Reference Balance
            $user = User::findOrFail($withdraw->user_id);
            $user->decrement('ref_balance', $withdraw->amount);
        });

        session()->flash('success', 'Withdrawal has been completed and balance updated.');
    }

    public function render()
    {
        $withdraws = Withdraw::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('livewire.backend.withdraw.index', [
            'withdraws' => $withdraws
        ]);
    }
}