<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // Required for Livewire 3
use Livewire\Component;

class Header extends Component
{
    /**
     * Listen for the wishlistUpdated event.
     * This method doesn't need to do anything; simply catching 
     * the event triggers a re-render of the component.
     */
    #[On('wishlistUpdated')]
    #[On('cartUpdated')] // Added this too as it's common for headers
    public function refreshComponent()
    {
        // Component re-renders automatically
    }

    public function render()
    {
        return view('livewire.frontend.theme.header', [
            'setting' => Setting::find(1),
            // We calculate this here or directly in the blade
            'wishlistCount' => Auth::check() ? Auth::user()->wishlist()->count() : 0
        ]);
    }
}
