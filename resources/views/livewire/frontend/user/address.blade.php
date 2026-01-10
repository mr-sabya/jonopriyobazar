<div class="col-lg-8 col-xl-9">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="font-weight-bold mb-0">Address Book</h3>
        @if(!$isCreating && !$isEditing)
        <button wire:click="toggleCreate" class="btn btn-primary br-10 px-4 shadow-sm">
            <i class="fas fa-plus mr-2"></i> Add New Address
        </button>
        @else
        <button wire:click="toggleCreate" class="btn btn-light br-10 px-4 border">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </button>
        @endif
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success br-10 border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    @if($isCreating || $isEditing)
    <!-- FORM SECTION -->
    <div class="card border-0 shadow-sm br-15">
        <div class="card-body p-4">
            <h5 class="font-weight-bold mb-4">{{ $isEditing ? 'Edit Address' : 'Add New Address' }}</h5>
            <form wire:submit.prevent="save">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">Recipient Name</label>
                        <input type="text" wire:model="name" class="form-control br-10 @error('name') is-invalid @enderror" placeholder="e.g. John Doe">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">Phone Number</label>
                        <input type="text" wire:model="phone" class="form-control br-10 @error('phone') is-invalid @enderror" placeholder="017XXXXXXXX">
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="small font-weight-bold text-muted text-uppercase">Street Address / House / Road</label>
                    <input type="text" wire:model="street" class="form-control br-10 @error('street') is-invalid @enderror" placeholder="House 12, Road 5, Sector 4...">
                    @error('street') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">District</label>
                        <select wire:model.live="district_id" class="form-control br-10 @error('district_id') is-invalid @enderror">
                            <option value="">-- Select District --</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">Thana</label>
                        <select wire:model.live="thana_id" class="form-control br-10 @error('thana_id') is-invalid @enderror" {{ empty($thanas) ? 'disabled' : '' }}>
                            <option value="">-- Select Thana --</option>
                            @foreach($thanas as $thana)
                            <option value="{{ $thana->id }}">{{ $thana->name }}</option>
                            @endforeach
                        </select>
                        @error('thana_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">City/Area</label>
                        <select wire:model="city_id" class="form-control br-10 @error('city_id') is-invalid @enderror" {{ empty($cities) ? 'disabled' : '' }}>
                            <option value="">-- Select City --</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold text-muted text-uppercase">Post Code</label>
                        <input type="text" wire:model="post_code" class="form-control br-10 @error('post_code') is-invalid @enderror" placeholder="1200">
                        @error('post_code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="small font-weight-bold text-muted text-uppercase">Address Type</label>
                    <div class="d-flex">
                        <label class="type-selector mr-3 {{ $type == 'home' ? 'active' : '' }}">
                            <input type="radio" wire:model="type" value="home" class="d-none">
                            <div class="box p-3 border br-10 text-center">
                                <i class="fas fa-home mb-1"></i> <br> <span>Home</span>
                            </div>
                        </label>
                        <label class="type-selector {{ $type == 'office' ? 'active' : '' }}">
                            <input type="radio" wire:model="type" value="office" class="d-none">
                            <div class="box p-3 border br-10 text-center">
                                <i class="fas fa-briefcase mb-1"></i> <br> <span>Office</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg px-5 shadow br-10 font-weight-bold" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ $isEditing ? 'Update Address' : 'Save Address' }}</span>
                    <span wire:loading>Saving...</span>
                </button>
            </form>
        </div>
    </div>
    @else
    <!-- LIST SECTION -->
    <div class="card border-0 shadow-sm br-15 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 px-4 small font-weight-bold text-muted">ADDRESS DETAILS</th>
                        <th class="border-0 small font-weight-bold text-muted">PHONE</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">SHIPPING</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">BILLING</th>
                        <th class="border-0 text-right px-4 small font-weight-bold text-muted">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($addresses as $address)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-weight-bold text-dark mb-1">{{ $address->name }}</p>
                            <p class="small text-muted mb-1">{{ $address->street }}, {{ $address->city->name ?? '' }}</p>
                            <span class="badge {{ $address->type == 'home' ? 'badge-primary-light text-primary' : 'badge-info-light text-info' }} px-2">
                                {{ ucfirst($address->type) }}
                            </span>
                        </td>
                        <td class="small font-weight-bold text-dark">{{ $address->phone }}</td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ship_{{ $address->id }}"
                                    wire:click="setShipping({{ $address->id }})" {{ $address->is_shipping ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ship_{{ $address->id }}"></label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="bill_{{ $address->id }}"
                                    wire:click="setBilling({{ $address->id }})" {{ $address->is_billing ? 'checked' : '' }}>
                                <label class="custom-control-label" for="bill_{{ $address->id }}"></label>
                            </div>
                        </td>
                        <td class="text-right px-4">
                            <button wire:click="edit({{ $address->id }})" class="btn btn-sm btn-outline-primary br-10">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted">No address found. Please add a new address.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

