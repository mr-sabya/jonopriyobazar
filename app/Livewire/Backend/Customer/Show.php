<?php

namespace App\Livewire\Backend\Customer;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $userId;
    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->userId = $id;
    }

    public function toggleReferStatus()
    {
        $user = User::findOrFail($this->userId);
        if($user->is_percentage == 1){
            $user->is_percentage = 0;
            session()->flash('success', "Customer refer percentage has been deactivated!");
        } else {
            $user->is_percentage = 1;
            session()->flash('success', "Customer refer percentage has been activated!");
        }
        $user->save();
    }

    public function render()
    {
        $user = User::findOrFail($this->userId);
        $addresses = Address::with(['city', 'thana', 'district'])->where('user_id', $user->id)->get();
        
        // Stats Orders (Status 3 - Delivered) - Used for the 0 ৳ calculations
        $statsOrders = Order::where('user_id', $user->id)->where('status', 3)->get();
        
        // Paginated Refer List
        $referredUsers = User::where('referral_id', $user->id)->latest()->paginate(10, ['*'], 'referPage');

        // Paginated Order History (All statuses)
        $paginatedOrders = Order::where('user_id', $user->id)->latest()->paginate(10, ['*'], 'orderPage');

        return view('livewire.backend.customer.show', [
            'user' => $user,
            'addresses' => $addresses,
            'statsOrders' => $statsOrders, // For calculations
            'referredUsers' => $referredUsers,
            'paginatedOrders' => $paginatedOrders, // For the table
            'refer_count' => User::where('referral_id', $user->id)->count(),
        ]);
    }
}