<?php

namespace App\Livewire\Frontend\Point;

use App\Models\User;
use App\Models\Prize;
use App\Models\UserPoint;
use App\Models\UserPrize;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Search & Sort Properties
    public $searchPoint = '';
    public $searchPrizeHistory = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function claimPrize($id)
    {
        $prize = Prize::findOrFail($id);
        $user = User::findOrFail(Auth::id());

        // Security check for points
        if ($user->point < $prize->point) {
            session()->flash('error', 'You do not have enough points to claim this prize.');
            return;
        }

        // 1. Create User Prize record
        UserPrize::create([
            'user_id' => $user->id,
            'prize_id' => $prize->id,
            'status' => 0, // Pending
        ]);

        // 2. Deduct points from user
        $user->decrement('point', $prize->point);

        session()->flash('success', 'Thank you for applying! We will contact you soon regarding your prize.');
    }

    public function render()
    {
        $user_id = Auth::id();

        // 1. Point Earnings History
        $points = UserPoint::with('order')
            ->where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('date', 'like', '%' . $this->searchPoint . '%')
                    ->orWhereHas('order', function ($q) {
                        $q->where('invoice', 'like', '%' . $this->searchPoint . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10, ['*'], 'pointPage');

        // 2. Prize Redemption History
        $user_prizes = UserPrize::with('prize')
            ->where('user_id', $user_id)
            ->whereHas('prize', function ($q) {
                $q->where('title', 'like', '%' . $this->searchPrizeHistory . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'prizePage');

        // 3. Available Prizes
        $prizes = Prize::orderBy('point', 'ASC')->get();

        return view('livewire.frontend.point.index', [
            'points' => $points,
            'prizes' => $prizes,
            'user_prizes' => $user_prizes
        ]);
    }
}
