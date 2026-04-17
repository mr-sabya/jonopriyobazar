<?php

namespace App\Livewire\Backend\Home;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Withdraw;
use App\Models\UserPrize;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    public $chartData = [];

    public function mount()
    {
        $this->loadIntelligence();
    }

    public function loadIntelligence()
    {
        // Daily Chart
        $daily = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')->orderBy('date')->get();

        // Monthly Chart
        $monthly = Order::select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('count(*) as count'), DB::raw('MONTH(created_at) as m'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'm')->orderBy('m')->get();

        // Yearly Chart
        $yearly = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();

        // Status Pie
        $statusNames = [1 => 'Pending', 2 => 'Processing', 3 => 'Delivered', 4 => 'Canceled'];
        $pie = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->map(fn($item) => [$statusNames[$item->status] ?? 'Other', $item->count])->toArray();

        $this->chartData = [
            'daily' => ['labels' => $daily->pluck('date')->map(fn($d) => Carbon::parse($d)->format('D'))->toArray(), 'data' => $daily->pluck('count')->toArray()],
            'monthly' => ['labels' => $monthly->pluck('month')->toArray(), 'data' => $monthly->pluck('count')->toArray()],
            'yearly' => ['labels' => $yearly->pluck('year')->toArray(), 'data' => $yearly->pluck('count')->toArray()],
            'pie' => $pie
        ];
    }

    public function render()
    {
        return view('livewire.backend.home.index', [
            // Original Segments
            'today_order' => Order::whereDate('created_at', Carbon::today())->get(),
            'month_order' => Order::whereMonth('created_at', date('m'))->get(),
            'orders'      => Order::get(),

            // Intelligence Tables
            'recent_products' => Product::latest()->take(5)->get(),
            'recent_orders'   => Order::with('customer')->latest()->take(5)->get(),
            'recent_users'    => User::latest()->take(5)->get(),
            'user_points'     => UserPoint::with('user')->latest()->take(5)->get(),
            'user_prizes'     => UserPrize::with(['user', 'prize'])->latest()->take(5)->get(),
            'withdrawals'     => Withdraw::with('user')->latest()->take(5)->get(),
            'stock_alerts'    => Product::where('quantity', '<', 10)->latest()->take(10)->get(),
        ]);
    }
}