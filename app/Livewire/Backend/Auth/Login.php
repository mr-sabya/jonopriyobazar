<?php

namespace App\Livewire\Backend\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email|max:50',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        // Attempt to login using the 'admin' guard
        if (Auth::guard('admin')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {

            session()->flash('success', 'Successfully Logged in!');
            return redirect()->intended(route('admin.dashboard'));
        } else {
            session()->flash('error', 'Invalid email and password');
            $this->reset('password');
        }
    }

    public function render()
    {
        // This tells Livewire which layout to wrap the component in
        return view('livewire.backend.auth.login');
    }
}
