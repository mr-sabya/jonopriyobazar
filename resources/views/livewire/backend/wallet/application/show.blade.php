<div class="container-fluid py-4">
    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- User Profile Card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(!$user->image)
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle img-thumbnail" width="120" alt="avatar">
                        @else
                        <img src="{{ url('upload/profile_pic', $user->image)}}" class="rounded-circle img-thumbnail" width="120" alt="avatar">
                        @endif
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->phone }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            User: {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge {{ $user->is_wallet == 1 ? 'bg-primary' : 'bg-warning text-dark' }}">
                            Wallet: {{ $user->is_wallet == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- NID Details -->
        <div class="col-md-8">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">National ID Documents</h5>
                </div>
                <div class="card-body text-center">
                    <div class="row g-2">
                        @if($user->n_id_front)
                        <div class="col-6">
                            <p class="small text-muted mb-1">Front Side</p>
                            <img src="{{ url('upload/images', $user->n_id_front)}}" class="img-fluid border rounded shadow-sm" alt="NID Front">
                        </div>
                        <div class="col-6">
                            <p class="small text-muted mb-1">Back Side</p>
                            <img src="{{ url('upload/images', $user->n_id_back)}}" class="img-fluid border rounded shadow-sm" alt="NID Back">
                        </div>
                        @else
                        <div class="col-12 py-5">
                            <p class="text-muted italic">No NID documents uploaded for this user.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Table -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Package History</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#packageModal">
                        <i class="zmdi zmdi-plus"></i> Assign New Package
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Package Details</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $package)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $package->package->amount }}</strong>
                                        <small class="text-muted">({{ $package->package->validate }} Days)</small>
                                    </td>
                                    <td>{{ $package->valid_from ? $package->valid_from->format('d-m-Y H:i') : '---' }}</td>
                                    <td>{{ $package->valid_to ? $package->valid_to->format('d-m-Y H:i') : '---' }}</td>
                                    <td>
                                        @if($package->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                        <span class="badge rounded-pill bg-secondary">Pending/Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($package->status == 0)
                                        <button wire:click="approve({{ $package->id }})" class="btn btn-success btn-sm me-1">Approve</button>
                                        <button wire:confirm="Are you sure you want to delete this request?" wire:click="delete({{ $package->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No packages assigned yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Modal -->
    <div wire:ignore.self class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="packageModalLabel">Assign Credit Wallet Package</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="assign">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Package</label>
                            <select wire:model="package_id" class="form-select @error('package_id') is-invalid @enderror" required>
                                <option value="">-- Choose a Package --</option>
                                @foreach($packs as $pack)
                                <option value="{{ $pack->id }}">{{ $pack->amount }} — {{ $pack->validate }} Days</option>
                                @endforeach
                            </select>
                            @error('package_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="alert alert-info py-2 small">
                            Note: Assigning a package will deactivate any currently active package for this user.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Assign Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Listen for Livewire event to close modal
        window.addEventListener('close-modal', event => {
            const modalElement = document.getElementById('packageModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        });
    </script>
</div>