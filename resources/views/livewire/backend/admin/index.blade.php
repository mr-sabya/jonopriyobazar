<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Administrator Management</h5>
                    @can('admin.admins.create')
                    <a href="{{ route('admin.admins.create') }}" wire:navigate class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-plus pe-1"></i> Add New Admin
                    </a>
                    @endcan
                </div>
                
                <div class="card-body">
                    <!-- Flash Messages -->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Table Controls -->
                    <div class="row mb-4">
                        <div class="col-md-1 d-flex align-items-center">
                            <select wire:model="perPage" class="form-select form-select-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-7"></div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.debounce.300ms="search" class="form-control border-start-0 ps-0" placeholder="Search by name or email...">
                                <div wire:loading wire:target="search" class="spinner-border spinner-border-sm text-primary ms-2 align-self-center"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-light">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" width="5%">#</th>
                                    <th class="border-0" style="cursor:pointer;" wire:click="sortBy('name')">
                                        Name @include('livewire.partials._sort-icon', ['field' => 'name'])
                                    </th>
                                    <th class="border-0" style="cursor:pointer;" wire:click="sortBy('email')">
                                        Email @include('livewire.partials._sort-icon', ['field' => 'email'])
                                    </th>
                                    <th class="border-0">Roles</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr>
                                    <td class="text-muted">{{ ($users->currentPage()-1) * $users->perPage() + $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-light text-primary d-flex align-items-center justify-content-center rounded-circle" style="width:32px; height:32px; font-weight:bold;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge rounded-pill bg-info-soft text-info border border-info px-3">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            @can('admin.admins.edit')
                                            <a href="{{ route('admin.admins.edit', $user->id) }}" wire:navigate class="btn btn-outline-secondary btn-sm border-0 shadow-none"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('admin.admins.destroy')
                                            <button onclick="confirm('Delete this user?') || event.stopImmediatePropagation()" wire:click="delete({{ $user->id }})" class="btn btn-outline-danger btn-sm border-0 shadow-none"><i class="fas fa-trash"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </small>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>