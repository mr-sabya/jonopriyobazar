<div class="section bg-light py-4">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('user.wallet.index') }}" class="btn btn-success shadow-sm btn-sm br-10 text-white px-3" wire:navigate>
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
            <h4 class="font-weight-bold mb-0">Reward Points</h4>
        </div>

        @if(session()->has('success'))
        <div class="alert alert-success br-10 shadow-sm border-0 mb-4">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger br-10 shadow-sm border-0 mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <!-- Total Points Card -->
                <div class="card border-0 shadow-sm br-15 mb-5 text-center overflow-hidden">
                    <div class="card-body p-4 bg-white">
                        <div class="icon-circle bg-warning-light text-warning mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-trophy fa-lg"></i>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ Auth::user()->point }}</h2>
                        <p class="text-muted small mb-0 text-uppercase font-weight-bold letter-spacing-1">Available Points</p>
                    </div>
                    <div class="bg-warning py-2 text-white small font-weight-bold">
                        Shop more to earn more rewards!
                    </div>
                </div>

                <!-- Prize Catalog -->
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-gift text-primary mr-2"></i>
                        <h5 class="font-weight-bold mb-0">Available Prizes to Claim</h5>
                    </div>
                    <div class="card border-0 shadow-sm br-15 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4">PRIZE</th>
                                        <th class="border-0">TITLE</th>
                                        <th class="border-0 text-center">POINTS REQUIRED</th>
                                        <th class="border-0 text-right px-4">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prizes as $prize)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="bg-light rounded p-1 d-inline-block border">
                                                <img src="{{ url('upload/images', $prize->prize) }}" class="img-fluid rounded" style="width: 60px; height: 50px; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td class="font-weight-bold text-dark">{{ $prize->title }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-pill badge-warning-light text-warning font-weight-bold px-3 py-2">
                                                {{ $prize->point }} <small>PTS</small>
                                            </span>
                                        </td>
                                        <td class="text-right px-4">
                                            @if(Auth::user()->point >= $prize->point)
                                            <button wire:click="claimPrize({{ $prize->id }})"
                                                wire:confirm="Are you sure you want to claim this prize?"
                                                class="btn btn-warning btn-sm px-4 br-10 shadow-sm font-weight-bold">
                                                Claim Now
                                            </button>
                                            @else
                                            <button class="btn btn-light btn-sm px-4 br-10 disabled text-muted" disabled>
                                                Need More Points
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- History Tabs -->
                <div class="card border-0 shadow-sm br-15">
                    <div class="card-header bg-white border-0 pt-3 px-4">
                        <ul class="nav nav-pills custom-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#points_history" role="tab">
                                    <i class="fas fa-coins mr-2"></i>Point History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#prizes_history" role="tab">
                                    <i class="fas fa-history mr-2"></i>Prize History
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- POINT EARNINGS -->
                            <div id="points_history" class="tab-pane active fade show" role="tabpanel">
                                <div class="d-md-flex align-items-center justify-content-between mb-4">
                                    <h6 class="font-weight-bold mb-0">Earnings from Orders</h6>
                                    <input type="text" wire:model.live="searchPoint" class="form-control form-control-sm w-25" placeholder="Search Invoice/Date...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0 cursor-pointer" wire:click="sortBy('date')">DATE</th>
                                                <th class="border-0">ORDER</th>
                                                <th class="border-0 text-right">POINTS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($points as $point)
                                            <tr>
                                                <td class="small">{{ date('d M, Y', strtotime($point->date)) }}</td>
                                                <td><span class="badge badge-light">#{{ $point->order['invoice'] ?? 'N/A' }}</span></td>
                                                <td class="text-right font-weight-bold text-success">+{{ $point->point }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted small">No point history found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $points->links() }}
                            </div>

                            <!-- PRIZE REDEMPTIONS -->
                            <div id="prizes_history" class="tab-pane fade" role="tabpanel">
                                <div class="d-md-flex align-items-center justify-content-between mb-4">
                                    <h6 class="font-weight-bold mb-0">My Claimed Prizes</h6>
                                    <input type="text" wire:model.live="searchPrizeHistory" class="form-control form-control-sm w-25" placeholder="Search Prize...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0">DATE</th>
                                                <th class="border-0">PRIZE TITLE</th>
                                                <th class="border-0 text-center">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($user_prizes as $user_prize)
                                            <tr>
                                                <td class="small">{{ date('d M, Y', strtotime($user_prize->created_at)) }}</td>
                                                <td class="font-weight-bold text-dark">{{ $user_prize->prize['title'] ?? 'Deleted Prize' }}</td>
                                                <td class="text-center">
                                                    @if($user_prize->status == 0)
                                                    <span class="badge badge-info px-3">Pending</span>
                                                    @elseif($user_prize->status == 1)
                                                    <span class="badge badge-success px-3">Completed</span>
                                                    @else
                                                    <span class="badge badge-danger px-3">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted small">No claimed prizes found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $user_prizes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

