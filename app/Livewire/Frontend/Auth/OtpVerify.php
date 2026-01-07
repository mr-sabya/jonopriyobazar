<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpVerify extends Component
{
    public $phone;
    public $code_1, $code_2, $code_3, $code_4;

    public function mount()
    {
        // Get phone from query string ?phone=...
        $this->phone = request()->query('phone');
    }

    public function verify()
    {
        // Validation: Check if any box is empty
        if (blank($this->code_1) || blank($this->code_2) || blank($this->code_3) || blank($this->code_4)) {
            $this->addError('otp_error', 'Please Enter your 4-digit OTP');
            return;
        }

        $user = User::where('phone', $this->phone)->first();

        if (!$user) {
            $this->addError('otp_error', 'User not found.');
            return;
        }

        // Concatenate the 4 inputs
        $inputCode = $this->code_1 . $this->code_2 . $this->code_3 . $this->code_4;

        if ($user->code == $inputCode) {
            // Success Logic
            $user->code = null;
            $user->is_varified = 1;
            $user->save();

            Auth::login($user);

            session()->flash('success', 'Phone verified successfully!');
            return $this->redirect(route('home'), navigate:true); // Adjust redirect route as needed
        } else {
            // Failure Logic
            $this->addError('otp_error', 'OTP code does not match! Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.otp-verify');
    }
}
