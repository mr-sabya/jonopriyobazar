<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use App\Models\User;
use App\SendCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Register extends Component
{
    public $name;
    public $phone;
    public $password;
    public $ref_code;
    public $agree;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:5',
            'agree' => 'accepted', // Ensures the checkbox is checked
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter your full name',
        'phone.required' => 'Please enter your phone number',
        'phone.unique' => 'This phone number is already registered',
        'password.required' => 'Please enter a password',
        'password.min' => 'Password must be at least 5 characters',
        'agree.accepted' => 'You must agree to the terms & policy',
    ];

    public function register()
    {
        $this->validate();

        $referral_id = null;

        // Check Reference Code
        if ($this->ref_code) {
            $refer = User::where('affiliate_code', $this->ref_code)->first();
            if (!$refer) {
                $this->addError('ref_code', 'Refer Code does not match with any user!');
                return;
            }
            $referral_id = $refer->id;
        }

        // Send OTP
        $code = SendCode::sendCode($this->phone);

        if ($code == "error") {
            $this->addError('otp_error', 'OTP send failed! Please Try Again!');
            return;
        }

        // Create User
        $user = new User;
        $user->name = $this->name;
        $user->username = $this->createUsername($this->name);
        $user->phone = $this->phone;
        $user->code = $code;
        $user->affiliate_code = time() . mt_rand(111111, 999999);
        $user->referral_id = $referral_id;
        $user->password = Hash::make($this->password);
        $user->status = 1;
        $user->is_varified = 0; // Set to 0 because OTP is sent
        $user->save();

        // Redirect to OTP verification page
        session()->flash('success', 'Registration successful! Please verify your phone.');
        return $this->redirect(route('otp.verify', ['phone' => $this->phone]), navigate:true);
    }

    protected function createUsername(string $name): string
    {
        $usernameFounds = $this->getUsernames($name);
        $counter = $usernameFounds;
        $username = Str::slug($name, '-');

        if ($counter > 0) {
            $username = $username . '-' . $counter;
        }
        return $username;
    }

    protected function getUsernames($name): int
    {
        return User::where('name', 'like', $name)->count();
    }

    public function render()
    {
        return view('livewire.frontend.auth.register');
    }
}
