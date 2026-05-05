<?php

namespace App\Livewire\Backend\Address;

use App\Models\City;
use App\Models\Thana;
use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class CityManager extends Component
{
    use WithPagination;

    // Table Controls
    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $name;
    public $delivery_charge;
    public $district_id = ''; // Selected District
    public $thana_id = '';    // Selected Thana
    public $cityId;
    public $isEditMode = false;

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|max:255|unique:cities,name,' . $this->cityId,
            'district_id' => 'required|exists:districts,id',
            'thana_id' => 'required|exists:thanas,id',
            'delivery_charge' => 'required|numeric|min:0',
        ];
    }

    /**
     * Reset form fields
     */
    public function resetInput()
    {
        $this->name = '';
        $this->delivery_charge = '';
        $this->district_id = '';
        $this->thana_id = '';
        $this->cityId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Store New City
     */
    public function store()
    {
        $this->validate();

        City::create([
            'name' => $this->name,
            'thana_id' => $this->thana_id,
            'delivery_charge' => $this->delivery_charge,
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'City/Area added successfully!']);
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Load data for Edit
     */
    public function edit($id)
    {
        $city = City::with('thana')->findOrFail($id);
        $this->cityId = $city->id;
        $this->name = $city->name;
        $this->delivery_charge = $city->delivery_charge;

        // Load the dependent dropdown values
        $this->district_id = $city->thana->district_id;
        $this->thana_id = $city->thana_id;

        $this->isEditMode = true;
        $this->dispatch('open-modal');
    }

    /**
     * Update existing City
     */
    public function update()
    {
        $this->validate();

        $city = City::findOrFail($this->cityId);
        $city->update([
            'name' => $this->name,
            'thana_id' => $this->thana_id,
            'delivery_charge' => $this->delivery_charge,
        ]);

        $this->dispatch('swal', ['type' => 'success', 'message' => 'City updated successfully!']);
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    /**
     * Delete City
     */
    public function delete($id)
    {
        City::findOrFail($id)->delete();
        $this->dispatch('swal', ['type' => 'success', 'message' => 'City deleted successfully!']);
    }

    /**
     * Reset Thana when District changes
     */
    public function updatedDistrictId()
    {
        $this->thana_id = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Fetch Cities with Search
        $cities = City::with('thana.district')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('thana', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        // 2. Fetch all Districts for the dropdown
        $districts = District::orderBy('name', 'asc')->get();

        // 3. Fetch Thanas filtered by selected District
        $thanas = !empty($this->district_id)
            ? Thana::where('district_id', $this->district_id)->orderBy('name', 'asc')->get()
            : [];

        return view('livewire.backend.address.city-manager', [
            'cities' => $cities,
            'districts' => $districts,
            'thanas' => $thanas
        ]);
    }
}
