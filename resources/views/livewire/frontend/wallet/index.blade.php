<div class="section bg-light py-5">
    <div class="container">
        <div class="row">
            <!-- LEFT SIDE: WALLET STATS DASHBOARD -->
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary p-2 rounded-lg mr-3 shadow-sm">
                        <i class="fas fa-wallet text-white fa-lg"></i>
                    </div>
                    <h4 class="font-weight-bold mb-0">My Wallet Overview</h4>
                </div>

                <div class="row wallet-grid">
                    <!-- Credit Balance Card -->
                    <div class="col-sm-6 mb-4">
                        <a href="{{ route('user.wallet.show') }}" wire:navigate class="text-decoration-none">
                            <div class="card border-0 shadow-sm br-15 h-100 overflow-hidden text-center transition-hover">
                                <div class="card-body py-4">
                                    <div class="icon-circle bg-primary-light text-primary mb-3 mx-auto">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <h3 class="font-weight-bold text-dark mb-1">৳{{ $user->wallet_balance }}</h3>
                                    <p class="text-muted small mb-3">Credit Balance</p>

                                    <!-- Added Link -->
                                    <div class="text-primary small font-weight-bold mt-2">
                                        View Statement <i class="fas fa-chevron-right ml-1" style="font-size: 10px;"></i>
                                    </div>
                                </div>
                                <div class="py-2 px-3 {{ ($user->is_hold == 1 || $user->is_expired == 1 || !$active_package) ? 'bg-danger' : 'bg-success' }} text-white small font-weight-bold">
                                    @if($user->is_hold == 1)
                                    <i class="fas fa-lock mr-1"></i> Wallet on Hold
                                    @elseif($user->is_expired == 1)
                                    <i class="fas fa-exclamation-circle mr-1"></i> Package Expired
                                    @elseif($active_package)
                                    <i class="fas fa-calendar-alt mr-1"></i> Ends: {{ date('d M Y', strtotime($active_package->valid_to)) }}
                                    @else
                                    <i class="fas fa-info-circle mr-1"></i> Inactive
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Refer Balance Card -->
                    <div class="col-sm-6 mb-4">
                        <a href="{{ route('user.refer.balance') }}" wire:navigate class="text-decoration-none">
                            <div class="card border-0 shadow-sm br-15 h-100 text-center transition-hover">
                                <div class="card-body py-4">
                                    <div class="icon-circle bg-info-light text-info mb-3 mx-auto">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <h3 class="font-weight-bold text-dark mb-1">৳{{ $user->ref_balance }}</h3>
                                    <p class="text-muted small mb-3">Referral Earnings</p>

                                    <!-- Added Link -->
                                    <div class="text-info small font-weight-bold mt-2">
                                        View Earnings <i class="fas fa-chevron-right ml-1" style="font-size: 10px;"></i>
                                    </div>
                                </div>
                                <div class="bg-light py-2 px-3 text-muted small border-top font-weight-bold">Only for shopping</div>
                            </div>
                        </a>
                    </div>

                    <!-- Points Card -->
                    <div class="col-sm-6 mb-4">
                        <a href="{{ route('user.point.index') }}" wire:navigate class="text-decoration-none">
                            <div class="card border-0 shadow-sm br-15 h-100 text-center transition-hover">
                                <div class="card-body py-4">
                                    <div class="icon-circle bg-warning-light text-warning mb-3 mx-auto">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h3 class="font-weight-bold text-dark mb-1">{{ $user->point }}</h3>
                                    <p class="text-muted small mb-3">Reward Points</p>

                                    <!-- Added Link -->
                                    <div class="text-warning small font-weight-bold mt-2">
                                        Redeem Points <i class="fas fa-chevron-right ml-1" style="font-size: 10px;"></i>
                                    </div>
                                </div>
                                <div class="bg-light py-2 px-3 text-muted small border-top font-weight-bold">Get Prize Only</div>
                            </div>
                        </a>
                    </div>

                    <!-- Total Refer Card -->
                    <div class="col-sm-6 mb-4">
                        <a href="{{ route('user.refer.index') }}" wire:navigate class="text-decoration-none">
                            <div class="card border-0 shadow-sm br-15 h-100 text-center transition-hover">
                                <div class="card-body py-4">
                                    <div class="icon-circle bg-success-light text-success mb-3 mx-auto">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h3 class="font-weight-bold text-dark mb-1">{{ $user->refers->count() }}</h3>
                                    <p class="text-muted small mb-3">Total Referrals</p>

                                    <!-- Added Link -->
                                    <div class="text-success small font-weight-bold mt-2">
                                        Manage Referrals <i class="fas fa-chevron-right ml-1" style="font-size: 10px;"></i>
                                    </div>
                                </div>
                                <div class="bg-light py-2 px-3 text-muted small border-top font-weight-bold">Refer more to earn</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: APPLICATION / PACKAGES -->
            <div class="col-lg-6">
                @if(session()->has('success'))
                <div class="alert alert-success br-10 shadow-sm border-0 mb-4 animate__animated animate__fadeIn">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
                @endif

                @if($user->is_wallet == 0)
                <!-- CASE: NOT ACTIVATED -->
                <div class="card border-0 shadow-sm br-15">
                    <div class="card-body p-4 text-center">
                        @if($user->wallet_request == 1)
                        <div class="py-5">
                            <div class="bg-warning-light text-warning rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-clock fa-3x"></i>
                            </div>
                            <h4 class="font-weight-bold">Application Pending</h4>
                            <p class="text-muted">We have received your NID documents. Our team is verifying your details. We will notify you shortly!</p>
                            <span class="badge badge-warning px-3 py-2">Verification in Progress</span>
                        </div>
                        @else
                        <div class="py-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" width="100" class="mb-3">
                            <h4 class="font-weight-bold">Activate Credit Wallet</h4>
                            <p class="text-muted px-lg-5">Get access to credit facilities by verifying your identity. It's safe and fast!</p>

                            <button wire:click="toggleApplyForm" class="btn btn-primary btn-lg shadow br-10 px-5 font-weight-bold">
                                {{ $showApplyForm ? 'Cancel Application' : 'Apply Now' }}
                            </button>

                            @if($showApplyForm)
                            <form wire:submit.prevent="submitWalletRequest" class="mt-4 text-left p-3 border rounded bg-white">
                                <div class="row">
                                    <!-- NID FRONT -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small">NID Front Side</label>
                                        <div class="nid-preview-container bg-light border-dashed rounded p-2 text-center position-relative">
                                            @if($n_id_front)
                                            <img src="{{ $n_id_front->temporaryUrl() }}" class="img-fluid rounded shadow-sm" style="max-height: 120px;">
                                            @else
                                            <div class="py-4">
                                                <i class="fas fa-id-card fa-2x text-muted mb-2"></i>
                                                <p class="mb-0 small text-muted">Click to Upload</p>
                                            </div>
                                            @endif
                                            <input type="file" wire:model="n_id_front" class="opacity-0 position-absolute w-100 h-100 top-0 start-0 cursor-pointer">
                                        </div>
                                        @error('n_id_front') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- NID BACK -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small">NID Back Side</label>
                                        <div class="nid-preview-container bg-light border-dashed rounded p-2 text-center position-relative">
                                            @if($n_id_back)
                                            <img src="{{ $n_id_back->temporaryUrl() }}" class="img-fluid rounded shadow-sm" style="max-height: 120px;">
                                            @else
                                            <div class="py-4">
                                                <i class="fas fa-id-card fa-2x text-muted mb-2"></i>
                                                <p class="mb-0 small text-muted">Click to Upload</p>
                                            </div>
                                            @endif
                                            <input type="file" wire:model="n_id_back" class="opacity-0 position-absolute w-100 h-100 top-0 start-0 cursor-pointer">
                                        </div>
                                        @error('n_id_back') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-block py-2 font-weight-bold shadow-sm mt-2" wire:loading.attr="disabled">
                                    <span wire:loading.remove><i class="fas fa-paper-plane mr-1"></i> Submit Application</span>
                                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Uploading...</span>
                                </button>
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <!-- CASE: ACTIVE - SHOW PACKAGES -->
                <div class="card border-0 shadow-sm br-15">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold mb-0 text-dark">Available Wallet Packages</h5>
                        <span class="badge badge-primary px-3">Active Wallet</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 small font-weight-bold">PACKAGE NAME</th>
                                        <th class="border-0 small font-weight-bold">VALIDITY</th>
                                        <th class="border-0 small font-weight-bold text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $package)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success-light text-success p-2 rounded mr-3 small">
                                                    <i class="fas fa-box"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block font-weight-bold text-dark">৳{{ $package->amount }}</span>
                                                    <span class="small text-muted">Limit Amount</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle small font-weight-bold text-muted">
                                            {{ $package->validate }} Days
                                        </td>
                                        <td class="text-right align-middle">
                                            @php $isApplied = $user->applyWallet($package->id); @endphp

                                            @if($isApplied)
                                            @if($user->wallet_package_id == $package->id)
                                            <span class="btn btn-sm btn-success px-3 br-10 disabled"><i class="fas fa-check-circle mr-1"></i> Active</span>
                                            @else
                                            <span class="btn btn-sm btn-outline-secondary px-3 br-10 disabled">Requested</span>
                                            @endif
                                            @else
                                            @if($user->wallet_package_id == null)
                                            <button wire:click="applyPackage({{ $package->id }})" class="btn btn-sm btn-primary px-4 br-10 shadow-sm" wire:loading.attr="disabled">
                                                <span wire:loading.remove>Apply</span>
                                                <span wire:loading><i class="fas fa-spinner fa-spin"></i></span>
                                            </button>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>