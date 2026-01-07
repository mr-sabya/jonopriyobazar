<?php

namespace App\Livewire\Frontend\Auth;

use App\SendCode;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $phone;
    public $password;
    public $remember;

    // Validation rules
    protected $rules = [
        'phone' => 'required',
        'password' => 'required|min:5',
    ];

    // Custom validation messages
    protected $messages = [
        'phone.required' => 'Please Enter your phone Number',
        'password.required' => 'Please Enter Password',
        'password.min' => 'Password must be at least 5 Characters',
    ];

    public function login()
    {
        $this->validate();

        $user = User::where('phone', $this->phone)->first();

        if ($user) {
            if ($user->is_varified == 1) {
                if (Auth::attempt(['phone' => $this->phone, 'password' => $this->password], $this->remember)) {
                    session()->flash('success', 'Login successful!');
                    return redirect()->intended(route('user.profile')); // Redirect to profile or dashboard
                } else {
                    $this->addError('phone', 'Phone and password does not match');
                }
            } else {
                // Handle Unverified User
                $code = SendCode::sendCode($this->phone);
                if ($code == "error") {
                    $this->addError('otp_error', 'OTP send failed! Please Try Again!');
                } else {
                    $user->code = $code;
                    $user->save();
                    // Redirect to verification page with phone in session
                    return redirect()->route('otp.verify', ['phone' => $this->phone]);
                }
            }
        } else {
            $this->addError('phone', 'This Phone number is not registered!');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.login');
    }
}
