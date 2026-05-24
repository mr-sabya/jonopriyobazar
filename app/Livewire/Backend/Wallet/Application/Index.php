<?php

namespace App\Livewire\Backend\Wallet\Application;

use App\Models\CustomerWallet;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $requests = CustomerWallet::where('status', 0)
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->with(['user', 'package'])
            ->latest()
            ->paginate(10);

        return view('livewire.backend.wallet.application.index', [
            'requests' => $requests
        ]);
    }
}
