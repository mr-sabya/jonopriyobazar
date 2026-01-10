<?php

namespace App\Livewire\Frontend\User;

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    // Profile Info Fields
    public $name;
    public $username;

    // Password Fields
    public $c_password;
    public $password;
    public $confirm_password;

    // New properties
    public $delete_password;
    public $two_factor_enabled;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->two_factor_enabled = $user->two_factor_enabled;
    }

    public function toggle2FA()
    {
        $user = User::find(Auth::id());
        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();
        $this->two_factor_enabled = $user->two_factor_enabled;

        $msg = $this->two_factor_enabled ? '2FA Enabled successfully.' : '2FA Disabled.';
        $this->dispatch('toast', ['type' => 'info', 'message' => $msg]);
    }

    public function deactivateAccount()
    {
        $user = User::find(Auth::id());
        $user->update(['deactivated_at' => now()]);

        Auth::logout();
        return redirect()->route('login')->with('status', 'Your account has been deactivated.');
    }

    public function deleteAccount()
    {
        $this->validate([
            'delete_password' => 'required'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($this->delete_password, $user->password)) {
            $this->addError('delete_password', 'Incorrect password. Deletion cancelled.');
            return;
        }

        // Cleanup resources (images, etc) before deleting if necessary
        $user->delete();

        Auth::logout();
        return redirect()->route('home')->with('success', 'Your account has been permanently deleted.');
    }


    /**
     * Update Personal Information
     */
    public function updateInfo()
    {
        $user = User::find(Auth::id());

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'name' => $this->name,
            'username' => $this->username,
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Your info has been changed!']);
    }

    /**
     * Update Password
     */
    public function updatePassword()
    {
        $this->validate([
            'c_password' => 'required|min:5',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password',
        ], [
            'confirm_password.same' => 'Confirm password does not match!',
        ]);

        $user = User::find(Auth::id());

        // Check if current password is correct
        if (!Hash::check($this->c_password, $user->password)) {
            $this->addError('c_password', 'Current password does not match!');
            return;
        }

        $user->update([
            'password' => Hash::make($this->password)
        ]);

        // Reset fields
        $this->reset(['c_password', 'password', 'confirm_password']);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Your password has been updated successfully']);
    }

    public function render()
    {
        $user_id = Auth::id();
        $shipping_address = Address::where('is_shipping', 1)->where('user_id', $user_id)->first();
        $billing_address = Address::where('is_billing', 1)->where('user_id', $user_id)->first();

        return view('livewire.frontend.user.profile', compact('shipping_address', 'billing_address'));
    }
}
