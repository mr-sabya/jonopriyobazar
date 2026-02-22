<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\User;
use App\SendCode;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $phone;

    protected $rules = [
        'phone' => 'required|numeric|digits_between:10,15',
    ];

    protected $messages = [
        'phone.required' => 'Please enter your phone number',
        'phone.numeric' => 'Phone number must be digits only',
    ];

    public function sendOtp()
    {
        $this->validate();

        $user = User::where('phone', $this->phone)->first();

        if ($user) {
            $code = SendCode::sendCode($this->phone);

            if ($code == "error") {
                $this->addError('otp_error', 'OTP send failed! Please Try Again!');
            } else {
                $user->code = $code;
                $user->save();

                // Redirect to the verification page
                // Inside ForgotPassword.php -> sendOtp()
                return $this->redirect(route('otp.verify', ['phone' => $this->phone, 'type' => 'reset']), navigate: true);
            }
        } else {
            $this->addError('phone', 'Wrong phone number! This number is not registered.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.forgot-password');
    }
}
