<?php

namespace App\Livewire\Frontend\Auth;

use App\SendCode;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $phone;
    public $password;
    public $remember;

    public function mount()
    {
        // Get the URL the user came from
        $previousUrl = url()->previous();
        $loginUrl = route('login');

        // Only store the URL if it's not the login page itself and not an external site
        // This prevents a "redirect loop" back to the login page
        if (!Session::has('url.intended')) {
            if ($previousUrl !== $loginUrl && !str_contains($previousUrl, '/livewire/update')) {
                Session::put('url.intended', $previousUrl);
            }
        }
    }

    protected $rules = [
        'phone' => 'required',
        'password' => 'required|min:5',
    ];

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

                    // 1. Get the intended URL or fallback to profile
                    $url = session()->pull('url.intended', route('user.profile'));
                    Session::regenerate();
                    // 2. Redirect with wire:navigate support
                    return $this->redirect($url, navigate: true);
                } else {
                    $this->addError('phone', 'Phone and password does not match');
                }
            } else {
                $code = SendCode::sendCode($this->phone);
                if ($code == "error") {
                    $this->addError('otp_error', 'OTP send failed! Please Try Again!');
                } else {
                    $user->code = $code;
                    $user->save();
                    return $this->redirect(route('otp.verify', ['phone' => $this->phone]), navigate: true);
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
