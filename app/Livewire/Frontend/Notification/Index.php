<?php

namespace App\Livewire\Frontend\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 20;

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        session()->flash('success', 'All notifications marked as read.');
    }

    public function readAndRedirect($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();

            $role = $notification->data['role'] ?? '';

            if ($role == 'wallet' || $role == 'walletpackage') {
                return $this->redirect(route('user.wallet.index'), navigate: true); // Updated to your route naming
            }

            // Add other conditions here if needed
            return $this->redirect(route('user.dashboard'), navigate: true);
        }
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notifications = $user->notifications()->paginate($this->perPage);

        return view('livewire.frontend.notification.index', [
            'notifications' => $notifications
        ]);
    }
}
