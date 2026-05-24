<?php

namespace App\Livewire\Backend\Customer\Point;

use App\Models\User;
use App\Models\UserPoint;
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
        
        $history = UserPoint::where('user_id', $this->userId)
            ->with('order')
            ->latest()
            ->paginate(15);

        return view('livewire.backend.customer.point.manage', [
            'user' => $user,
            'history' => $history
        ]);
    }
}