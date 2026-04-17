<?php

namespace App\Livewire\Backend\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $roleId, $name;
    public $selectedPermissions = [];

    // UI State
    public $isEditMode = false;
    public $search = '';
    public $deleteId = null;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $user = Admin::find(Auth::id());
        if (!$user->can('admin.roles.index')) abort(403);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->selectedPermissions = [];
        $this->roleId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Modal Logic
     */
    public function create()
    {
        $this->resetFields();
        $this->dispatch('show-role-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        $role = Role::findById($id, 'admin');
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();

        $this->dispatch('show-role-modal');
    }

    /**
     * Permission Logic
     */
    public function toggleAll()
    {
        $allCount = Permission::count();
        if (count($this->selectedPermissions) === $allCount) {
            $this->selectedPermissions = [];
        } else {
            $this->selectedPermissions = Permission::pluck('name')->toArray();
        }
    }

    public function toggleGroup($groupName)
    {
        $groupPermissions = Admin::getpermissionsByGroupName($groupName)->pluck('name')->toArray();

        // Check if all permissions in this group are already selected
        $hasAll = true;
        foreach ($groupPermissions as $p) {
            if (!in_array($p, $this->selectedPermissions)) {
                $hasAll = false;
                break;
            }
        }

        if ($hasAll) {
            // Remove the group
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPermissions);
        } else {
            // Add missing permissions from group
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $groupPermissions));
        }
    }

    /**
     * Action Logic
     */
    public function store()
    {
        $this->validate(['name' => 'required|max:100|unique:roles,name']);

        $role = Role::create(['name' => $this->name, 'guard_name' => 'admin']);
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('hide-role-modal');
        session()->flash('success', 'Role Created Successfully');
    }

    public function update()
    {
        $this->validate(['name' => 'required|max:100|unique:roles,name,' . $this->roleId]);

        $role = Role::findById($this->roleId, 'admin');
        $role->name = $this->name;
        $role->save();
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('hide-role-modal');
        session()->flash('success', 'Role Updated Successfully');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        Role::findById($this->deleteId)->delete();
        $this->dispatch('hide-delete-modal');
        session()->flash('success', 'Role Deleted Successfully');
    }

    public function render()
    {
        return view('livewire.backend.roles.index', [
            'roles' => Role::with('permissions')
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10),
            'permission_groups' => Admin::getpermissionGroups(),
            'total_permissions' => Permission::count()
        ]);
    }
}
