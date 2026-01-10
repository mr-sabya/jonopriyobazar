<?php

namespace App\Livewire\Frontend\User;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        $shipping_address = Address::where('is_shipping', 1)->where('user_id', Auth::user()->id)->first();
        $billing_address = Address::where('is_billing', 1)->where('user_id', Auth::user()->id)->first();
        return view('livewire.frontend.user.profile', compact('shipping_address', 'billing_address'));
    }
}
