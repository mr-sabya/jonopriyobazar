<?php

namespace App\Livewire\Backend\Wallet\WalletRequest;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Filter Properties
    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    public $selectedUser;
    protected $paginationTheme = 'bootstrap';

    /**
     * Reset pagination when filters change
     */
    public function updatedSearch() { $this->resetPage(); }
    public function updatedDateFrom() { $this->resetPage(); }
    public function updatedDateTo() { $this->resetPage(); }

    /**
     * Reset all filters
     */
    public function resetFilters()
    {
        $this->reset(['search', 'dateFrom', 'dateTo']);
    }

    public function showRequest($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->dispatch('open-modal', id: 'requestDetailModal');
    }

    public function approve($id = null)
    {
        $id = $id ?? $this->selectedUser->id;
        $user = User::findOrFail($id);

        $user->update([
            'is_wallet' => 1,
            'wallet_request' => 0,
            'status' => 1,
            'is_hold' => 0
        ]);

        $this->dispatch('close-modal', id: 'requestDetailModal');
        $this->dispatch('swal', [
            'title' => 'Approved!',
            'text' => 'Wallet access granted to ' . $user->name,
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        $query = User::query()->where('wallet_request', 1);

        // Search Filter
        $query->when($this->search, function($q) {
            $q->where(function($sub) {
                $sub->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        });

        // Date Range Filter
        $query->when($this->dateFrom, function($q) {
            $q->whereDate('request_date', '>=', $this->dateFrom);
        })->when($this->dateTo, function($q) {
            $q->whereDate('request_date', '<=', $this->dateTo);
        });

        $requests = $query->latest('request_date')->paginate(15);

        return view('livewire.backend.wallet.wallet-request.index', [
            'requests' => $requests
        ]);
    }
}