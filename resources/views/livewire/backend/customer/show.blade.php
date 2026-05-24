<div>
    @if (session()->has('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Profile Header -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-center">
                        <div class="avatar position-relative d-inline-block">
                            @if($user->image == null)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle border" width="100" alt="{{ $user->name }}">
                            @else
                            <img src="{{ url('upload/profile_pic', $user->image)}}" class="rounded-circle border" width="100" height="100" alt="{{ $user->name }}">
                            @endif
                            @if($user->is_varified == 1)
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white"><i class="ri-check-line text-white"></i></span>
                            @else
                            <span class="position-absolute bottom-0 end-0 bg-danger rounded-circle p-1 border border-2 border-white"><i class="ri-close-line text-white"></i></span>
                            @endif
                        </div>
                        <div class="mt-2">
                            <h3>{{ $user->name }}</h3>
                            <p>{{ $user->phone }}</p>
                            <span class="badge {{ $user->status == 1 ? 'bg-success' : ($user->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $user->status == 1 ? 'Active' : ($user->status == 2 ? 'Hold' : 'Deactive') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 1: Wallet, Refer, Point -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-4 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Credit Wallet Balance</h4>
                            <h3 class="fw-bold">৳ {{ number_format($user->wallet_balance, 2) }}</h3>

                            <!-- button to open modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#walletModal">
                                Credit Wallet
                            </button>
                            <!-- Modal -->
                        </div>
                        <div class="col-md-4 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Refer Balance</h4>
                            <h3 class="fw-bold">৳ {{ number_format($user->ref_balance, 2) }}</h3>

                            <!-- button to open modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#referModal">
                                Refer History
                            </button>
                            <!-- Modal -->
                        </div>
                        <div class="col-md-4">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Total Point</h4>
                            <h3 class="fw-bold">{{ $user->point }}</h3>
                            <!-- button to open modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pointModal">
                                Point History
                            </button>
                            <!-- Modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Order Type Totals (Product, Custom, Medicine, Electricity) -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-3 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Product Order</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('type', 'product')->sum('grand_total'), 2) }}</h4>
                        </div>
                        <div class="col-md-3 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Custom Order</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('type', 'custom')->sum('grand_total'), 2) }}</h4>
                        </div>
                        <div class="col-md-3 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Medicine Order</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('type', 'medicine')->sum('grand_total'), 2) }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Electricity Bill</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('type', 'electricity')->sum('grand_total'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Payment Type Totals (Cash, Credit, Refer) -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-4 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">On Cash</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('payment_option', 'cash')->sum('grand_total'), 2) }}</h4>
                        </div>
                        <div class="col-md-4 border-end">
                            <h4 class="p-0 m-0 text-muted small fw-bold">On Credit</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('payment_option', 'wallet')->sum('grand_total'), 2) }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4 class="p-0 m-0 text-muted small fw-bold">Refer Balance</h4>
                            <h4 class="fw-bold">৳ {{ number_format($statsOrders->where('payment_option', 'refer')->sum('grand_total'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address List -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5><strong>Address</strong> List</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Shipping</th>
                                <th>Billing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $address)
                            <tr>
                                <td class="ps-3">{{ $address->name }}</td>
                                <td>
                                    {{ $address->street }}, {{ $address->city['name'] }}-{{ $address->post_code }}, {{ $address->thana['name'] }}, {{ $address->district['name'] }}
                                    @if($address->type == 'home') <span class="badge bg-primary">Home</span> @elseif($address->type == 'office') <span class="badge bg-info">Office</span> @endif
                                </td>
                                <td>{{ $address->phone }}</td>
                                <td><input type="checkbox" disabled {{ $address->is_shipping == 1 ? 'checked' : '' }}></td>
                                <td><input type="checkbox" disabled {{ $address->is_billing == 1 ? 'checked' : '' }}></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Refer List -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5><strong>Refer</strong> List ({{ $refer_count }})</h5>
                    <button wire:click="toggleReferStatus" class="btn btn-sm {{ $user->is_percentage == 0 ? 'btn-success' : 'btn-danger' }}">
                        {{ $user->is_percentage == 0 ? 'Active Refer Percentage' : 'Deactive Refer Percentage' }}
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Verify Status</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referredUsers as $index => $refer)
                            <tr>
                                <td class="ps-3">{{ $referredUsers->firstItem() + $index }}</td>
                                <td>{{ $refer->name }}</td>
                                <td>{{ $refer->phone }}</td>
                                <td><span class="badge {{ $refer->is_varified == 1 ? 'bg-success' : 'bg-warning' }}">{{ $refer->is_varified == 1 ? 'Verified' : 'Unverified' }}</span></td>
                                <td><span class="badge {{ $refer->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $refer->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                <td class="text-center"><a href="{{ route('admin.customer.show', $refer->id) }}" class="btn btn-sm btn-outline-primary" wire:navigate><i class="ri-eye-line"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">{{ $referredUsers->links() }}</div>
            </div>
        </div>

        <!-- Order History Table -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5><strong>Order</strong> List</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Time + Area</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedOrders as $index => $order)
                            <tr>
                                <td class="ps-3">{{ $paginatedOrders->firstItem() + $index }}</td>
                                <td>
                                    <div class="small fw-bold">{{ $order->created_at->diffForHumans() }}</div>
                                    <div class="text-muted small">{{ $order->shippingAddress->city->name ?? 'N/A' }}</div>
                                </td>
                                <td>#{{ $order->invoice }}</td>
                                <td class="fw-bold">৳ {{ number_format($order->grand_total, 2) }}</td>
                                <td class="text-uppercase small">
                                    {{ $order->payment_option == 'cash' ? 'Cash On Delivery' : ($order->payment_option == 'wallet' ? 'Credit Wallet' : 'Refer Wallet') }}
                                </td>
                                <td><span class="badge bg-secondary">{{ $order->type }}</span></td>
                                <td>
                                    @php
                                    $stMap = [0=>['Pending','warning'], 1=>['Received','primary'], 2=>['Packed','info'], 3=>['Delivered','success'], 4=>['Canceled','danger']];
                                    $curr = $stMap[$order->status] ?? ['Unknown','secondary'];
                                    @endphp
                                    <span class="badge bg-{{ $curr[1] }}">{{ $curr[0] }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    @php
                                    $route = match($order->type) {
                                    'custom' => 'admin.customorder.show',
                                    'electricity' => 'admin.electricity.show',
                                    'medicine' => 'admin.medicine.show',
                                    default => 'admin.order.show'
                                    };
                                    @endphp
                                    <a href="{{ route($route, $order->id) }}" class="btn btn-sm btn-outline-success"><i class="ri-eye-line"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">{{ $paginatedOrders->links() }}</div>
            </div>
        </div>
    </div>

    <!-- refer history model -->
    <div class="modal fade" id="referModal" tabindex="-1" aria-labelledby="referModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="referModalLabel">Refer History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:backend.customer.referbalance.manage id="{{ $user->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- point history model -->
    <div class="modal fade" id="pointModal" tabindex="-1" aria-labelledby="pointModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pointModalLabel">Point History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:backend.customer.point.manage id="{{ $user->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- credit wallet model -->
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walletModalLabel">Credit Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:backend.wallet.wallet-user.show id="{{ $user->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>