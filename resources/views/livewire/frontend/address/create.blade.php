<div class="col-lg-8 col-xl-9">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="font-weight-bold mb-0">Add New Address</h3>
        <a href="{{ route('user.address.index') }}" class="btn btn-light br-10 px-4 border">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm br-15">
        <div class="card-body p-4">
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
                        <label class="type-selector mr-3">
                            <input type="radio" wire:model="type" value="home" class="d-none">
                            <div class="box p-3 border br-10 text-center {{ $type == 'home' ? 'bg-primary text-white border-primary' : '' }}" style="cursor: pointer; min-width: 100px;">
                                <i class="fas fa-home mb-1"></i> <br> <span>Home</span>
                            </div>
                        </label>
                        <label class="type-selector">
                            <input type="radio" wire:model="type" value="office" class="d-none">
                            <div class="box p-3 border br-10 text-center {{ $type == 'office' ? 'bg-primary text-white border-primary' : '' }}" style="cursor: pointer; min-width: 100px;">
                                <i class="fas fa-briefcase mb-1"></i> <br> <span>Office</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg px-5 shadow br-10 font-weight-bold" wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Address</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i>Saving...</span>
                </button>
            </form>
        </div>
    </div>
</div>