<?php

namespace App\Livewire\Backend\Setup;

use App\Models\CancelReason;
use Livewire\Component;
use Livewire\WithPagination;

class CancelReasonManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $name;
    public $reasonId;
    public $isEditMode = false;

    // Search & Delete
    public $search = '';
    public $deleteId;

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:cancel_reasons,name,' . $this->reasonId,
        ];
    }

    /**
     * Reset form fields
     */
    public function resetInput()
    {
        $this->name = '';
        $this->reasonId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Open Modal for Create
     */
    public function create()
    {
        $this->resetInput();
        $this->dispatch('open-modal', id: 'reasonModal');
    }

    /**
     * Store New Reason
     */
    public function store()
    {
        $this->validate();

        CancelReason::create(['name' => $this->name]);

        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Cancel Reason added successfully',
            'icon' => 'success'
        ]);

        $this->dispatch('close-modal', id: 'reasonModal');
        $this->resetInput();
    }

    /**
     * Load Data for Edit
     */
    public function edit($id)
    {
        $this->resetInput();
        $reason = CancelReason::findOrFail($id);
        $this->reasonId = $reason->id;
        $this->name = $reason->name;
        $this->isEditMode = true;

        $this->dispatch('open-modal', id: 'reasonModal');
    }

    /**
     * Update Existing Reason
     */
    public function update()
    {
        $this->validate();

        $reason = CancelReason::findOrFail($this->reasonId);
        $reason->update(['name' => $this->name]);

        $this->dispatch('swal', [
            'title' => 'Updated!',
            'text' => 'Cancel Reason updated successfully',
            'icon' => 'success'
        ]);

        $this->dispatch('close-modal', id: 'reasonModal');
        $this->resetInput();
    }

    /**
     * Confirm Delete
     */
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('open-modal', id: 'confirmDeleteModal');
    }

    /**
     * Final Deletion
     */
    public function delete()
    {
        CancelReason::findOrFail($this->deleteId)->delete();

        $this->dispatch('swal', [
            'title' => 'Deleted!',
            'text' => 'Cancel Reason has been removed',
            'icon' => 'success'
        ]);

        $this->dispatch('close-modal', id: 'confirmDeleteModal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reasons = CancelReason::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.setup.cancel-reason-manager', [
            'reasons' => $reasons
        ]);
    }
}
