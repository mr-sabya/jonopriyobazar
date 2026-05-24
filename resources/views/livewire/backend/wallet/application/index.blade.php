<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Wallet Request</strong> List</h5>
                    <div class="col-md-4">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by name or phone...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Package</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $index => $request)
                                <tr>
                                    <td>{{ $requests->firstItem() + $index }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->user->phone }}</td>
                                    <td>{{ $request->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $request->package->amount }} — {{ $request->package->validate }} days
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.packageapplication.show', $request->user->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="zmdi zmdi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No pending requests found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>