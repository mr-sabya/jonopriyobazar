<?php

namespace App\Livewire\Backend\Address;

use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class DistrictManager extends Component
{
    use WithPagination;

    // Search and Pagination
    public $search = '';
    public $perPage = 10;

    // Form Properties
    public $name;
    public $districtId;
    public $isEditMode = false;

    protected $paginationTheme = 'bootstrap';

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:districts,name,' . $this->districtId,
        ];
    }

    /**
     * Reset form fields
     */
    public function resetInput()
    {
        $this->name = '';
        $this->districtId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Create New District
     */
    public function store()
    {
        $this->validate();

        District::create(['name' => $this->name]);

        $this->dispatch('swal', [
            'type' => 'success',
            'message' => 'District added successfully!'
        ]);

        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Load data for Editing
     */
    public function edit($id)
    {
        $district = District::findOrFail($id);
        $this->districtId = $district->id;
        $this->name = $district->name;
        $this->isEditMode = true;

        $this->dispatch('open-modal');
    }

    /**
     * Update existing District
     */
    public function update()
    {
        $this->validate();

        $district = District::findOrFail($this->districtId);
        $district->update(['name' => $this->name]);

        $this->dispatch('swal', [
            'type' => 'success',
            'message' => 'District updated successfully!'
        ]);

        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Delete District with Relationship Check
     */
    public function delete($id)
    {
        $district = District::with('thanas')->findOrFail($id);

        if ($district->thanas->count() > 0) {
            $this->dispatch('swal', [
                'type' => 'error',
                'message' => 'Cannot delete! This district has active Thanas.'
            ]);
            return;
        }

        $district->delete();
        $this->dispatch('swal', [
            'type' => 'success',
            'message' => 'District deleted successfully!'
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $districts = District::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.backend.address.district-manager', [
            'districts' => $districts
        ]);
    }
}
