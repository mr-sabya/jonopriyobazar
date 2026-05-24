<?php

namespace App\Livewire\Backend\Userprize;

use App\Models\UserPrize;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    // Reset pagination when searching
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Mark prize as completed/given
     */
    public function complete($id)
    {
        $userprize = UserPrize::findOrFail($id);
        $userprize->status = 1;
        $userprize->save();

        session()->flash('success', 'Prize has been marked as given to the user.');
    }

    public function render()
    {
        $userprizes = UserPrize::with(['user', 'prize'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy('status', 'ASC') // Show pending first
            ->latest()
            ->paginate(15);

        return view('livewire.backend.userprize.index', [
            'userprizes' => $userprizes
        ]);
    }
}