<div class="section bg-light py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('user.wallet.index') }}" class="btn btn-white shadow-sm btn-sm br-10 text-dark px-3" wire:navigate>
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
            <h4 class="font-weight-bold mb-0">Refer Wallet</h4>
        </div>

        @if(session()->has('success'))
        <div class="alert alert-success br-10 shadow-sm border-0 mb-4">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <!-- Summary -->
                <div class="card border-0 shadow-sm br-15 mb-4 text-center">
                    <div class="card-body p-4">
                        <div class="icon-circle bg-info-light text-info mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-friends fa-lg"></i>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">৳{{ Auth::user()->ref_balance }}</h2>
                        <p class="text-muted small mb-0 text-uppercase font-weight-bold">Current Refer Balance</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm br-15">
                    <div class="card-header bg-white border-0 pt-3 px-4">
                        <ul class="nav nav-pills custom-pills" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#balance_tab">Earnings</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#purchase_tab">Purchases</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#withdraw_tab">Withdrawals</a></li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- EARNINGS -->
                            <div id="balance_tab" class="tab-pane active fade show">
                                <div class="d-md-flex align-items-center justify-content-between mb-3">
                                    <h6 class="font-weight-bold mb-0">Earning History</h6>
                                    <input type="text" wire:model.live="searchBalance" class="form-control form-control-sm w-25" placeholder="Search...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th wire:click="sortBy('date')" class="cursor-pointer border-0">DATE</th>
                                                <th class="border-0">ORDER</th>
                                                <th wire:click="sortBy('amount')" class="text-right cursor-pointer border-0">AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($balances as $balance)
                                            <tr>
                                                <td class="small">{{ date('d-m-Y', strtotime($balance->date)) }}</td>
                                                <td><span class="badge badge-light">#{{ $balance->order['invoice'] ?? 'N/A' }}</span></td>
                                                <td class="text-right font-weight-bold text-success">+৳{{ $balance->amount }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $balances->links() }}
                            </div>

                            <!-- PURCHASES -->
                            <div id="purchase_tab" class="tab-pane fade">
                                <div class="d-md-flex align-items-center justify-content-between mb-3">
                                    <h6 class="font-weight-bold mb-0">Purchase History</h6>
                                    <input type="text" wire:model.live="searchPurchase" class="form-control form-control-sm w-25" placeholder="Search...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th wire:click="sortBy('date')" class="cursor-pointer border-0">DATE</th>
                                                <th class="border-0">ORDER</th>
                                                <th wire:click="sortBy('amount')" class="text-right cursor-pointer border-0">AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchases as $purchase)
                                            <tr>
                                                <td class="small">{{ date('d-m-Y', strtotime($purchase->date)) }}</td>
                                                <td><span class="badge badge-light">#{{ $purchase->order['invoice'] ?? 'N/A' }}</span></td>
                                                <td class="text-right font-weight-bold text-danger">-৳{{ $purchase->amount }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $purchases->links() }}
                            </div>

                            <!-- WITHDRAWALS -->
                            <div id="withdraw_tab" class="tab-pane fade">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="font-weight-bold mb-0">Withdrawal History</h6>
                                    <button class="btn btn-primary btn-sm br-10" data-toggle="modal" data-target="#withdrawModal">
                                        <i class="fas fa-plus mr-1"></i> Request Withdraw
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0">DATE</th>
                                                <th class="border-0 text-right">AMOUNT</th>
                                                <th class="border-0 text-center">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($withdraws as $withdraw)
                                            <tr>
                                                <td class="small">{{ date('d-m-Y', strtotime($withdraw->created_at)) }}</td>
                                                <td class="text-right font-weight-bold">৳{{ $withdraw->amount }}</td>
                                                <td class="text-center">
                                                    @if($withdraw->status == 0) <span class="badge badge-warning">Pending</span>
                                                    @elseif($withdraw->status == 1) <span class="badge badge-success">Paid</span>
                                                    @else <span class="badge badge-danger">Rejected</span> @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $withdraws->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div wire:ignore.self class="modal fade" id="withdrawModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content br-15 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="font-weight-bold mb-0">Withdraw Request</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body pt-0">
                    <form wire:submit.prevent="storeWithdraw">
                        <div class="form-group">
                            <label class="small text-muted font-weight-bold">Amount to Withdraw</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-white">৳</span></div>
                                <input type="number" wire:model="withdraw_amount" class="form-control @error('withdraw_amount') is-invalid @enderror" placeholder="Enter amount">
                            </div>
                            @error('withdraw_amount') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block br-10 py-2 font-weight-bold">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('close-modal', event => {
        $('#withdrawModal').modal('hide');
    });
</script>