<?php

namespace App\Livewire\Frontend\Address;

use App\Models\City;
use App\Models\Thana;
use App\Models\District;
use App\Models\Address as AddressModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
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

        AddressModel::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'phone' => $this->phone,
            'street' => $this->street,
            'district_id' => $this->district_id,
            'thana_id' => $this->thana_id,
            'city_id' => $this->city_id,
            'post_code' => $this->post_code,
            'type' => $this->type,
            'is_shipping' => AddressModel::where('user_id', Auth::id())->count() === 0 ? 1 : 0,
            'is_billing' => AddressModel::where('user_id', Auth::id())->count() === 0 ? 1 : 0,
        ]);

        session()->flash('success', 'New address added successfully.');

        return $this->redirect(route('checkout.index'), navigate:true); // Adjust route name as per your web.php
    }

    public function render()
    {
        return view('livewire.frontend.address.create');
    }
}
