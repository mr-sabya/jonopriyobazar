<?php

namespace App\Livewire\Frontend\Medicine;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Address;
use App\Models\District;
use App\Models\Thana;
use App\Models\City;
use App\Notifications\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    // Address Properties
    public $name, $phone, $street, $district_id, $thana_id, $city_id, $post_code, $type = 'home';

    // Order Properties
    public $custom, $image, $payment_option = 'cash';
    public $shipping_address, $billing_address;

    // Collections
    public $districts = [], $thanas = [], $cities = [];

    public function mount()
    {
        $this->districts = District::orderBy('name', 'ASC')->get();
        $this->loadUserAddresses();
    }

    public function loadUserAddresses()
    {
        $this->shipping_address = Address::where('user_id', Auth::id())->where('is_shipping', 1)->first();
        $this->billing_address = Address::where('user_id', Auth::id())->where('is_billing', 1)->first();
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

    public function store()
    {
        // 1. Validation Logic from your Controller
        $rules = [
            'image' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
            'custom' => 'nullable|string',
            'payment_option' => 'required',
        ];

        if (!$this->shipping_address) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
                'phone' => 'required',
                'street' => 'required|max:255',
                'district_id' => 'required',
                'thana_id' => 'required',
                'city_id' => 'required',
                'post_code' => 'required',
                'type' => 'required',
            ]);
        }

        $this->validate($rules);

        // 2. Create Address if not exists
        if (!$this->shipping_address) {
            $address = Address::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'phone' => $this->phone,
                'street' => $this->street,
                'district_id' => $this->district_id,
                'thana_id' => $this->thana_id,
                'city_id' => $this->city_id,
                'post_code' => $this->post_code,
                'type' => $this->type,
                'is_shipping' => 1,
                'is_billing' => 1,
            ]);
            $this->loadUserAddresses();
        }

        // 3. Create Medicine Order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->invoice = time() . rand(11111, 99999);
        $order->shipping_address_id = $this->shipping_address->id;
        $order->billing_address_id = $this->billing_address->id ?? $this->shipping_address->id;
        $order->type = 'medicine';
        $order->payment_option = $this->payment_option;
        $order->custom = $this->custom;

        // Image Handling
        if ($this->image) {
            $extension = $this->image->getClientOriginalName();
            $filename = time() . '-medicine-order-' . $extension;
            // Store in public/upload/images
            $this->image->storeAs('images', $filename, 'public_uploads');
            $order->image = $filename;
        }

        $order->save();

        // 4. Notifications
        $admins = Admin::all();
        $data = [
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'name' => Auth::user()->name,
        ];

        foreach ($admins as $admin) {
            $admin->notify(new OrderRequest($data));
        }

        session()->flash('success', 'Thank you for your order!');
        return redirect()->route('order.complete');
    }

    public function render()
    {
        return view('livewire.frontend.medicine.index');
    }
}
