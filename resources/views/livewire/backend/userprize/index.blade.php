<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">User Prize Management</h5>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control bg-light border-start-0" placeholder="Search user or phone...">
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <!-- Flash Messages -->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                            <i class="ri-check-line me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>User Details</th>
                                    <th>Prize Information</th>
                                    <th class="text-center">Points Cost</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userprizes as $index => $prize)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $userprizes->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $prize->user['name'] }}</div>
                                        <div class="small text-muted">{{ $prize->user['phone'] }}</div>
                                    </td>
                                    <td>
                                        <span class="text-primary fw-semibold">{{ $prize->prize['title'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-light text-dark border">
                                            {{ number_format($prize->prize['point']) }} Pts
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($prize->status == 0)
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Pending</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Given</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        @if($prize->status == 0)
                                            <button 
                                                wire:click="complete({{ $prize->id }})" 
                                                wire:confirm="Are you sure you have delivered this prize?"
                                                class="btn btn-sm btn-outline-success">
                                                Mark as Given
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-light disabled text-muted border">
                                                <i class="ri-checkbox-circle-line me-1"></i> Completed
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="ri-gift-line ri-2x mb-2 d-block"></i>
                                        No prize requests found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination Footer -->
                @if($userprizes->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $userprizes->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>