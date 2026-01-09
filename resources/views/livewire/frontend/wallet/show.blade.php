<div class="section py-4">
    <div class="container">
        <!-- Back Button & Page Title -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('user.wallet') }}" wire:navigate class="btn btn-white shadow-sm btn-sm br-10 text-dark px-3">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
            </div>
            <h4 class="font-weight-bold mb-0">Wallet Statement</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Summary Card -->
                <div class="card border-0 shadow-sm br-15 mb-4 overflow-hidden">
                    <div class="card-body p-4 text-center bg-white">
                        <div class="icon-circle bg-primary-light text-primary mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-wallet fa-lg"></i>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">৳{{ Auth::user()->wallet_balance }}</h2>
                        <p class="text-muted small mb-2 text-uppercase font-weight-bold">Current Credit Balance</p>

                        <div class="d-inline-block px-3 py-1 rounded-pill small font-weight-bold {{ $active_package ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }}">
                            @if($active_package)
                            <i class="fas fa-calendar-check mr-1"></i> Expires: {{ date('d-M-Y h:i A', strtotime($active_package->valid_to)) }}
                            @else
                            <i class="fas fa-times-circle mr-1"></i> Wallet is not Active
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tabs Container -->
                <div class="card border-0 shadow-sm br-15">
                    <div class="card-header bg-white border-0 pt-3 px-4">
                        <ul class="nav nav-pills custom-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#purchases" role="tab">
                                    <i class="fas fa-shopping-cart mr-2"></i>Purchase History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#payments" role="tab">
                                    <i class="fas fa-receipt mr-2"></i>Payment History
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- PURCHASE HISTORY TAB -->
                            <div id="purchases" class="tab-pane active fade show" role="tabpanel">
                                <div class="d-md-flex align-items-center justify-content-between mb-4">
                                    <h5 class="font-weight-bold mb-3 mb-md-0">Order Usage</h5>
                                    <div class="search-box">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                                            </div>
                                            <input type="text" wire:model.live="searchPurchase" class="form-control border-left-0" placeholder="Search Invoice or Date...">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0 cursor-pointer" wire:click="sortBy('date')">
                                                    DATE <i class="fas fa-sort-{{ $sortField == 'date' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                                </th>
                                                <th class="border-0">INVOICE</th>
                                                <th class="border-0 text-right cursor-pointer" wire:click="sortBy('amount')">
                                                    AMOUNT <i class="fas fa-sort-{{ $sortField == 'amount' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($purchases as $purchase)
                                            <tr>
                                                <td class="font-weight-bold small">{{ date('d M, Y', strtotime($purchase->date)) }}</td>
                                                <td>
                                                    <span class="badge badge-light px-2 py-1 text-primary">#{{ $purchase->order['invoice'] ?? 'N/A' }}</span>
                                                </td>
                                                <td class="text-right font-weight-bold text-danger">- ৳{{ $purchase->amount }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">No purchase records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $purchases->links() }}
                                </div>
                            </div>

                            <!-- PAYMENT HISTORY TAB -->
                            <div id="payments" class="tab-pane fade" role="tabpanel">
                                <div class="d-md-flex align-items-center justify-content-between mb-4">
                                    <h5 class="font-weight-bold mb-3 mb-md-0">Wallet Recharges</h5>
                                    <div class="search-box">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                                            </div>
                                            <input type="text" wire:model.live="searchPayment" class="form-control border-left-0" placeholder="Search Amount or Date...">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0">#</th>
                                                <th class="border-0 cursor-pointer" wire:click="sortBy('date')">
                                                    DATE <i class="fas fa-sort-{{ $sortField == 'date' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                                </th>
                                                <th class="border-0 text-right cursor-pointer" wire:click="sortBy('amount')">
                                                    RECHARGE AMOUNT <i class="fas fa-sort-{{ $sortField == 'amount' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pays as $pay)
                                            <tr>
                                                <td class="small text-muted">{{ $loop->iteration + ($pays->currentPage()-1)*10 }}</td>
                                                <td class="font-weight-bold small">{{ date('d M, Y', strtotime($pay->date)) }}</td>
                                                <td class="text-right font-weight-bold text-success">+ ৳{{ $pay->amount }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">No payment records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $pays->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
