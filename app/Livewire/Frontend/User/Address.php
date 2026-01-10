<?php

namespace App\Livewire\Frontend\User;

use App\Models\City;
use App\Models\Thana;
use App\Models\Address as AddressModel;
use App\Models\District;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Address extends Component
{
    // View State
    public $isCreating = false;
    public $isEditing = false;
    public $editId = null;

    // Form Fields
    public $name, $phone, $street, $district_id, $thana_id, $city_id, $post_code, $type = 'home';

    // Dropdown Data
    public $districts = [], $thanas = [], $cities = [];

    public function mount()
    {
        $this->districts = District::orderBy('name', 'ASC')->get();
    }

    public function updatedDistrictId($id)
    {
        $this->thanas = Thana::where('district_id', $id)->orderBy('name', 'ASC')->get();
        $this->reset(['thana_id', 'city_id', 'cities']);
    }

    public function updatedThanaId($id)
    {
        $this->cities = City::where('thana_id', $id)->orderBy('name', 'ASC')->get();
        $this->reset('city_id');
    }

    public function toggleCreate()
    {
        if ($this->isCreating || $this->isEditing) {
            $this->isCreating = false;
            $this->isEditing = false;
            $this->resetFields();
        } else {
            $this->isCreating = true;
        }
    }

    public function edit($id)
    {
        $address = AddressModel::findOrFail($id);
        $this->editId = $id;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->street = $address->street;
        $this->district_id = $address->district_id;

        // Pre-load dependent dropdowns
        $this->thanas = Thana::where('district_id', $this->district_id)->get();
        $this->thana_id = $address->thana_id;

        $this->cities = City::where('thana_id', $this->thana_id)->get();
        $this->city_id = $address->city_id;

        $this->post_code = $address->post_code;
        $this->type = $address->type;

        $this->isEditing = true;
        $this->isCreating = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'street' => 'required|max:255',
            'district_id' => 'required',
            'thana_id' => 'required',
            'city_id' => 'required',
            'post_code' => 'required',
            'type' => 'required',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'name' => $this->name,
            'phone' => $this->phone,
            'street' => $this->street,
            'district_id' => $this->district_id,
            'thana_id' => $this->thana_id,
            'city_id' => $this->city_id,
            'post_code' => $this->post_code,
            'type' => $this->type,
        ];

        if ($this->isEditing) {
            AddressModel::find($this->editId)->update($data);
            session()->flash('success', 'Address updated successfully.');
        } else {
            AddressModel::create($data);
            session()->flash('success', 'New address added successfully.');
        }

        $this->toggleCreate();
        $this->resetFields();
    }

    public function setShipping($id)
    {
        $address = AddressModel::findOrFail($id);
        if ($address->is_shipping) return;

        AddressModel::where('user_id', Auth::id())->update(['is_shipping' => 0]);
        $address->update(['is_shipping' => 1]);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Default shipping address updated']);
    }

    public function setBilling($id)
    {
        $address = AddressModel::findOrFail($id);
        if ($address->is_billing) return;

        AddressModel::where('user_id', Auth::id())->update(['is_billing' => 0]);
        $address->update(['is_billing' => 1]);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Default billing address updated']);
    }

    public function resetFields()
    {
        $this->reset(['name', 'phone', 'street', 'district_id', 'thana_id', 'city_id', 'post_code', 'type', 'editId', 'thanas', 'cities']);
        $this->type = 'home';
    }

    public function render()
    {
        return view('livewire.frontend.user.address', [
            'addresses' => AddressModel::where('user_id', Auth::id())->get()
        ]);
    }
}
