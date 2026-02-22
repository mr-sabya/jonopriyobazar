<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $phone;
    public $password;
    public $password_confirmation;

    public function mount($phone)
    {
        // Getting phone from the URL query parameter ?phone=xxxx
        $this->phone = $phone;

        // Optional: Redirect if phone is missing
        // dd($this->phone);
    }

    protected $rules = [
        'password' => 'required|min:6|confirmed',
    ];

    protected $messages = [
        'password.required' => 'Please enter a new password.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function changePassword()
    {
        $this->validate();

        $user = User::where('phone', $this->phone)->first();

        if ($user) {
            $user->password = Hash::make($this->password);
            $user->save();

            session()->flash('success', 'Your password has been reset successfully!');
            return $this->redirect(route('login'), navigate: true);
        } else {
            $this->addError('phone', 'User not found.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.reset-password');
    }
}
