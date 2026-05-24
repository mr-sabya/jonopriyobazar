<?php

namespace App\Livewire\Backend\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.backend.auth.logout');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('admin.login');
    }
}
