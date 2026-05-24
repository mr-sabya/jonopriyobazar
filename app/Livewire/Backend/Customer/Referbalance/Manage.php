<?php

namespace App\Livewire\Backend\Customer\Referbalance;

use App\Models\User;
use App\Models\RefPercentage;
use Livewire\Component;
use Livewire\WithPagination;

class Manage extends Component
{
    use WithPagination;

    public $userId;
    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->userId = $id;
    }

    public function render()
    {
        $user = User::findOrFail($this->userId);

        $history = RefPercentage::where('user_id', $this->userId)
            ->with('order')
            ->latest()
            ->paginate(15);

        return view('livewire.backend.customer.referbalance.manage', [
            'user' => $user,
            'history' => $history
        ]);
    }
}
