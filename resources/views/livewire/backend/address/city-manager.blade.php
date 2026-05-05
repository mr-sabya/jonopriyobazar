<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">City/Area Management</h5>
                    <button class="btn btn-primary shadow-sm" wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#cityModal">
                        <i class="fas fa-plus me-2"></i>Add New City
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search city or thana...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>City/Area Name</th>
                                    <th>Thana / District</th>
                                    <th>Delivery Charge</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cities as $index => $city)
                                <tr>
                                    <td>{{ $cities->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ $city->name }}</td>
                                    <td>
                                        <div class="small fw-bold text-dark">{{ $city->thana->name ?? 'N/A' }}</div>
                                        <div class="small text-muted">{{ $city->thana->district->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-soft text-success px-3 rounded-pill">
                                            {{ number_format($city->delivery_charge, 2) }} ৳
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button wire:click="edit({{ $city->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#cityModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="confirm('Delete this area?') || event.stopImmediatePropagation()" wire:click="delete({{ $city->id }})" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No cities found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $cities->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="cityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold mb-0">{{ $isEditMode ? 'Edit City/Area' : 'Add New City/Area' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">District</label>
                            <select wire:model.live="district_id" class="form-select shadow-none @error('district_id') is-invalid @enderror">
                                <option value="">-- select district --</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Thana</label>
                            <select wire:model="thana_id"
                                wire:key="thana-select-for-district-{{ $district_id }}"
                                class="form-select shadow-none @error('thana_id') is-invalid @enderror" @disabled(empty($district_id))>
                                <option value="">-- select thana --</option>
                                @foreach($thanas as $thana)
                                <option value="{{ $thana->id }}">{{ $thana->name }}</option>
                                @endforeach
                            </select>
                            @error('thana_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">City/Area Name</label>
                            <input type="text" wire:model="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="small fw-bold text-muted mb-2">Delivery Charge (৳)</label>
                            <input type="number" step="0.01" wire:model="delivery_charge" class="form-control shadow-none @error('delivery_charge') is-invalid @enderror" placeholder="0.00">
                            @error('delivery_charge') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-2"></span>
                            {{ $isEditMode ? 'Update Area' : 'Save Area' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>