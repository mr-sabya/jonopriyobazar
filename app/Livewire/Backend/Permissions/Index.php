<?php

namespace App\Livewire\Backend\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $isEditMode = false;
    public $deleteId = null; // Store ID for deletion

    // Bulk Add
    public $inputs = [];

    // Single Update
    public $permissionId, $edit_name, $edit_group_name;

    public function mount()
    {
        $this->resetBulkFields();
    }

    public function resetBulkFields()
    {
        $this->inputs = [['name' => '', 'group_name' => '']];
        $this->isEditMode = false;
        $this->permissionId = null;
    }

    public function addRow()
    {
        $this->inputs[] = ['name' => '', 'group_name' => ''];
    }

    public function removeRow($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    public function storeBulk()
    {
        $this->validate([
            'inputs.*.name' => 'required|string|max:255|unique:permissions,name',
            'inputs.*.group_name' => 'required|string|max:255',
        ]);

        foreach ($this->inputs as $input) {
            Permission::create([
                'name' => $input['name'],
                'group_name' => $input['group_name'],
                'guard_name' => 'admin',
            ]);
        }

        $this->resetBulkFields();
        session()->flash('success', 'Permissions added successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->edit_name = $permission->name;
        $this->edit_group_name = $permission->group_name;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'edit_name' => 'required|string|max:255|unique:permissions,name,' . $this->permissionId,
            'edit_group_name' => 'required|string|max:255',
        ]);

        Permission::findOrFail($this->permissionId)->update([
            'name' => $this->edit_name,
            'group_name' => $this->edit_group_name,
        ]);

        $this->resetBulkFields();
        session()->flash('success', 'Permission updated successfully.');
    }

    /**
     * Delete Logic
     */
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        // Trigger browser event to show modal
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function destroy()
    {
        if ($this->deleteId) {
            Permission::findOrFail($this->deleteId)->delete();
            $this->deleteId = null;
            $this->dispatchBrowserEvent('hide-delete-modal');
            session()->flash('success', 'Permission deleted successfully.');
        }
    }

    public function render()
    {
        return view('livewire.backend.permissions.index', [
            'permissions' => Permission::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('group_name', 'like', '%' . $this->search . '%')
                ->orderBy('group_name', 'ASC')
                ->paginate(10)
        ]);
    }
}
