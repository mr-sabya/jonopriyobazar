<div class="col-lg-8 col-xl-9">

    <!-- Welcome Message -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Welcome, {{ Auth::user()->name }}!</h3>
            <p class="text-muted mb-0">Here is what's happening with your account today.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="text-muted small">Last Login: {{ now()->format('d M, h:i A') }}</span>
        </div>
    </div>

    <!-- 1. Financial Stat Cards -->
    <div class="row mb-2">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm br-15 transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-light text-primary p-2 rounded mr-3">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <span class="small font-weight-bold text-muted text-uppercase">Wallet Balance</span>
                    </div>
                    <h3 class="font-weight-bold mb-1">৳{{ Auth::user()->wallet_balance }}</h3>
                    <a href="{{ route('user.wallet.index') }}" class="small text-primary font-weight-bold" wire:navigate>View History <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm br-15 transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning-light text-warning p-2 rounded mr-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <span class="small font-weight-bold text-muted text-uppercase">Reward Points</span>
                    </div>
                    <h3 class="font-weight-bold mb-1">{{ Auth::user()->point }}</h3>
                    <a href="{{ route('user.point.index') }}" class="small text-warning font-weight-bold" wire:navigate>Redeem Points <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm br-15 transition-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info-light text-info p-2 rounded mr-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="small font-weight-bold text-muted text-uppercase">Refer Earnings</span>
                    </div>
                    <h3 class="font-weight-bold mb-1">৳{{ Auth::user()->ref_balance }}</h3>
                    <a href="{{ route('user.refer.balance') }}" class="small text-info font-weight-bold" wire:navigate>Manage Refers <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Quick Action Section -->
    <h5 class="font-weight-bold mb-3 mt-2">Quick Services</h5>
    <div class="row mb-4">
        <div class="col-md-4 col-6 mb-3">
            <a href="{{ route('custom.order') }}" class="text-decoration-none" wire:navigate>
                <div class="card border-0 shadow-sm br-15 text-center p-3 transition-hover h-100">
                    <i class="fas fa-clipboard-list fa-2x text-success mb-2"></i>
                    <h6 class="font-weight-bold text-dark mb-0">Custom Order</h6>
                    <p class="small text-muted mb-0">Write your list</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-6 mb-3">
            <a href="{{ route('medicine.index') }}" class="text-decoration-none" wire:navigate>
                <div class="card border-0 shadow-sm br-15 text-center p-3 transition-hover h-100">
                    <i class="fas fa-prescription fa-2x text-primary mb-2"></i>
                    <h6 class="font-weight-bold text-dark mb-0">Order Medicine</h6>
                    <p class="small text-muted mb-0">Upload Prescription</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <a href="{{ route('electricity.index') }}" class="text-decoration-none" wire:navigate>
                <div class="card border-0 shadow-sm br-15 text-center p-3 transition-hover h-100">
                    <i class="fas fa-bolt fa-2x text-warning mb-2"></i>
                    <h6 class="font-weight-bold text-dark mb-0">Electricity Bill</h6>
                    <p class="small text-muted mb-0">Pay Bill Instantly</p>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. Recent Activity / Orders -->
    <div class="card border-0 shadow-sm br-15">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold mb-0">Recent Orders</h5>
            <a href="{{ route('profile.order.index') }}" class="btn btn-sm btn-light br-10 px-3 font-weight-bold" wire:navigate>View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 small font-weight-bold">INVOICE</th>
                            <th class="border-0 small font-weight-bold">TYPE</th>
                            <th class="border-0 small font-weight-bold">DATE</th>
                            <th class="border-0 small font-weight-bold">STATUS</th>
                            <th class="border-0 px-4 small font-weight-bold text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        // You would typically pass this from a Controller
                        $recentOrders = App\Models\Order::where('user_id', Auth::id())->latest()->take(5)->get();
                        @endphp

                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-4 font-weight-bold text-primary small">#{{ $order->invoice }}</td>
                            <td><span class="text-capitalize small font-weight-bold">{{ $order->type }}</span></td>
                            <td class="small text-muted">{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                @if($order->status == 0) <span class="badge badge-warning px-2 py-1">Pending</span>
                                @elseif($order->status == 1) <span class="badge badge-success px-2 py-1">Delivered</span>
                                @else <span class="badge badge-danger px-2 py-1">Cancelled</span> @endif
                            </td>
                            <td class="px-4 text-right font-weight-bold text-dark">৳{{ $order->grand_total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <p class="text-muted mb-0 small">No orders found yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>