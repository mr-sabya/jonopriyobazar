<div class="section bg-light py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('user.wallet.index') }}" class="btn btn-success shadow-sm btn-sm br-10 text-white px-3" wire:navigate>
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
            <h4 class="font-weight-bold mb-0">My Referrals</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm br-15 mb-4 text-center">
                    <div class="card-body p-4">
                        <div class="icon-circle bg-success-light text-success mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ Auth::user()->refers->count() }}</h2>
                        <p class="text-muted small mb-0 text-uppercase font-weight-bold">Total Referred Users</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm br-15">
                    <div class="card-body p-4">
                        <div class="d-md-flex align-items-center justify-content-between mb-4">
                            <h5 class="font-weight-bold mb-3 mb-md-0">User List</h5>
                            <div class="search-box" style="width: 250px;">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                    <input type="text" wire:model.live="search" class="form-control border-left-0" placeholder="Name or Phone...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 cursor-pointer" wire:click="sortBy('name')">
                                            NAME <i class="fas fa-sort-{{ $sortField == 'name' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                        </th>
                                        <th class="border-0">PHONE</th>
                                        <th class="border-0 text-right cursor-pointer" wire:click="sortBy('created_at')">
                                            JOINED DATE <i class="fas fa-sort-{{ $sortField == 'created_at' ? $sortDirection : 'amount' }} ml-1 small opacity-50"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($refers as $refer)
                                    <tr>
                                        <td class="font-weight-bold text-dark">{{ $refer->name }}</td>
                                        <td>{{ $refer->phone }}</td>
                                        <td class="text-right small text-muted">{{ date('d M, Y', strtotime($refer->created_at)) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">No referrals found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $refers->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>