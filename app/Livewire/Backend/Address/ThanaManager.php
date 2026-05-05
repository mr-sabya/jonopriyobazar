<?php

namespace App\Livewire\Backend\Address;

use App\Models\Thana;
use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class ThanaManager extends Component
{
    use WithPagination;

    // Table Controls
    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $name;
    public $district_id;
    public $thanaId;
    public $isEditMode = false;

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|max:255|unique:thanas,name,' . $this->thanaId,
            'district_id' => 'required|exists:districts,id',
        ];
    }

    /**
     * Reset form fields
     */
    public function resetInput()
    {
        $this->name = '';
        $this->district_id = '';
        $this->thanaId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Save New Thana
     */
    public function store()
    {
        $this->validate();

        Thana::create([
            'name' => $this->name,
            'district_id' => $this->district_id
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'Thana added successfully!']);
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Load data for Edit
     */
    public function edit($id)
    {
        $thana = Thana::findOrFail($id);
        $this->thanaId = $thana->id;
        $this->name = $thana->name;
        $this->district_id = $thana->district_id;
        $this->isEditMode = true;

        $this->dispatch('open-modal');
    }

    /**
     * Update existing Thana
     */
    public function update()
    {
        $this->validate();

        $thana = Thana::findOrFail($this->thanaId);
        $thana->update([
            'name' => $this->name,
            'district_id' => $this->district_id
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'Thana updated successfully!']);
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Delete Thana with check for assigned cities
     */
    public function delete($id)
    {
        $thana = Thana::with('city')->findOrFail($id);

        if ($thana->city->count() > 0) {
            $this->dispatch('swal', [
                'type' => 'error',
                'message' => 'Cannot delete! This thana has active cities/areas assigned to it.'
            ]);
            return;
        }

        $thana->delete();
        $this->dispatch('swal', ['type' => 'success', 'message' => 'Thana deleted successfully!']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $thanas = Thana::with('district')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('district', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        $districts = District::orderBy('name', 'asc')->get();

        return view('livewire.backend.address.thana-manager', [
            'thanas' => $thanas,
            'districts' => $districts
        ]);
    }
}
