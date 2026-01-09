<?php

namespace App\Livewire\Frontend\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        // Logout specifically from the web guard
        Auth::guard('web')->logout();

        // Invalidate the session and regenerate the CSRF token
        session()->invalidate();
        session()->regenerateToken();

        // Redirect to homepage or login page
        return $this->redirect(route('home'), navigate:true);
    }

    public function render()
    {
        return view('livewire.frontend.auth.logout');
    }
}
