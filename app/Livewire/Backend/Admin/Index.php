<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // DataTable Properties
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'bootstrap';

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        if (!Auth::user()->can('admin.admins.destroy')) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $admin = Admin::findOrFail($id);
        if ($admin->id === Auth::id()) {
            session()->flash('error', 'You cannot delete yourself.');
            return;
        }

        $admin->delete();
        session()->flash('success', 'Admin deleted successfully.');
    }

    public function render()
    {
        $users = Admin::with('roles')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.admin.index', [
            'users' => $users
        ]);
    }
}