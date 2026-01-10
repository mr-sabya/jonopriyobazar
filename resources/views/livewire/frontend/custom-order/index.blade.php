<div class="section py-5">
    <div class="custom-container custom-order">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Header -->
                <div class="text-center mb-5">
                    <h2 class="font-weight-bold text-dark">Custom Order Form</h2>
                    <p class="text-muted">কাস্টম অর্ডার ফরমের মাধ্যমে দ্রুত অর্ডার সম্পন্ন করুন</p>
                    <div class="bg-success mx-auto" style="width: 50px; height: 3px;"></div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <form wire:submit.prevent="store">

                            <!-- 1. ADDRESS SECTION -->
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-pill badge-success mr-2" style="width:25px; height:25px; line-height:18px;">1</span>
                                <h5 class="mb-0 font-weight-bold">Delivery Address</h5>
                            </div>

                            @if(!$shipping_address)
                            <div class="card border-0 shadow-sm mb-4 br-15">
                                <div class="card-body p-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">Recipient Name</label>
                                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name">
                                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">Phone Number</label>
                                            <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="017XXXXXXXX">
                                            @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="small font-weight-bold text-muted">Street Address / House / Road</label>
                                        <input type="text" wire:model="street" class="form-control @error('street') is-invalid @enderror" placeholder="House 12, Road 5, Block A">
                                        @error('street') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">District</label>
                                            <select wire:model.live="district_id" class="form-control">
                                                <option value="">-- Select District --</option>
                                                @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">Thana</label>
                                            <select wire:model.live="thana_id" class="form-control" {{ empty($thanas) ? 'disabled' : '' }}>
                                                <option value="">-- Select Thana --</option>
                                                @foreach ($thanas as $thana)
                                                <option value="{{ $thana->id }}">{{ $thana->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">City/Area</label>
                                            <select wire:model="city_id" class="form-control" {{ empty($cities) ? 'disabled' : '' }}>
                                                <option value="">-- Select City --</option>
                                                @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small font-weight-bold text-muted">Post Code</label>
                                            <input type="text" wire:model="post_code" class="form-control" placeholder="1200">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="small font-weight-bold text-muted">Address Type</label>
                                        <div class="form-row custom-selection">
                                            <div class="col-6">
                                                <label class="select-box {{ $type == 'home' ? 'active' : '' }}">
                                                    <input type="radio" value="home" wire:model="type" class="d-none">
                                                    <i class="fas fa-home"></i> <span>Home</span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="select-box {{ $type == 'office' ? 'active' : '' }}">
                                                    <input type="radio" value="office" wire:model="type" class="d-none">
                                                    <i class="fas fa-briefcase"></i> <span>Office</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="card border-0 shadow-sm mb-4 br-15 overflow-hidden">
                                <div class="bg-light p-3 border-bottom">
                                    <p class="mb-0 small text-success font-weight-bold"><i class="fas fa-check-circle"></i> Using saved address</p>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <h6 class="small font-weight-bold text-muted mb-2">SHIPPING ADDRESS</h6>
                                            <p class="mb-1 font-weight-bold">{{ $shipping_address->name }}</p>
                                            <p class="small text-muted mb-0">{{ $shipping_address->street }}, {{ $shipping_address->city->name ?? '' }}</p>
                                            <p class="small text-muted">{{ $shipping_address->phone }}</p>
                                        </div>
                                        <div class="col-md-6 pl-md-4">
                                            <h6 class="small font-weight-bold text-muted mb-2">BILLING ADDRESS</h6>
                                            <p class="mb-1 font-weight-bold">{{ $billing_address->name ?? $shipping_address->name }}</p>
                                            <p class="small text-muted mb-0">{{ $billing_address->street }}, {{ $billing_address->city->name ?? '' }}</p>
                                            <p class="small text-muted">{{ $billing_address->phone ?? $shipping_address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 2. ORDER CONTENT -->
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-pill badge-success mr-2" style="width:25px; height:25px; line-height:18px;">2</span>
                                <h5 class="mb-0 font-weight-bold">Order Details</h5>
                            </div>

                            <div class="card border-0 shadow-sm mb-4 br-15">
                                <div class="card-body p-4">
                                    <div class="form-group">
                                        <label class="small font-weight-bold text-muted">Write your Bazar List</label>
                                        <textarea wire:model="custom" class="form-control br-10" rows="5" placeholder="1. Rice - 5kg..."></textarea>
                                        @error('custom') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="text-center my-3 text-muted small font-weight-bold">OR UPLOAD PHOTO</div>
                                    <div class="custom-file-upload text-center p-4 border rounded">
                                        <input type="file" wire:model="image" id="file-upload" class="d-none">
                                        <label for="file-upload" style="cursor: pointer;">
                                            <i class="fas fa-camera fa-2x text-success mb-2"></i>
                                            <p class="mb-0 small font-weight-bold">Click to Upload Image</p>
                                        </label>
                                        <div wire:loading wire:target="image" class="small text-primary">Uploading...</div>
                                        @if($image) <div class="small text-success mt-2">Selected: {{ $image->getClientOriginalName() }}</div> @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 3. PAYMENT -->
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-pill badge-success mr-2" style="width:25px; height:25px; line-height:18px;">3</span>
                                <h5 class="mb-0 font-weight-bold">Payment Method</h5>
                            </div>

                            <div class="card border-0 shadow-sm mb-4 br-15">
                                <div class="card-body p-4">
                                    @php $user = Auth::user(); @endphp

                                    <div class="payment-list">
                                        <!-- COD -->
                                        <label class="payment-box d-flex align-items-center {{ $payment_option == 'cash' ? 'active' : '' }}">
                                            <input type="radio" wire:model="payment_option" value="cash" class="mr-3">
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold">Cash On Delivery</span>
                                                <span class="small text-muted">Pay after receiving items</span>
                                            </div>
                                            <i class="fas fa-truck text-success"></i>
                                        </label>

                                        <!-- Wallet -->
                                        @php
                                        $walletDisabled = ($user->is_wallet != 1 || $user->is_hold == 1 || $user->is_expired == 1);
                                        $walletReason = "Wallet is not active.";
                                        if($user->is_hold == 1) $walletReason = "Your wallet is on hold.";
                                        elseif($user->is_expired == 1) $walletReason = "Your wallet is expired.";
                                        @endphp
                                        <label class="payment-box d-flex align-items-center {{ $walletDisabled ? 'disabled' : ($payment_option == 'wallet' ? 'active' : '') }}">
                                            <input type="radio" wire:model="payment_option" value="wallet" class="mr-3" {{ $walletDisabled ? 'disabled' : '' }}>
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold">Credit Wallet</span>
                                                <span class="small text-muted">Use balance</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if($walletDisabled)
                                                <span class="mr-2" data-toggle="tooltip" title="{{ $walletReason }}"><i class="fas fa-question-circle text-muted"></i></span>
                                                @endif
                                                <i class="fas fa-wallet text-primary"></i>
                                            </div>
                                        </label>

                                        <!-- Refer -->
                                        @php $referDisabled = $user->is_percentage != 1; @endphp
                                        <label class="payment-box d-flex align-items-center {{ $referDisabled ? 'disabled' : ($payment_option == 'reffer' ? 'active' : '') }}">
                                            <input type="radio" wire:model="payment_option" value="reffer" class="mr-3" {{ $referDisabled ? 'disabled' : '' }}>
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold">Refer Wallet</span>
                                            </div>
                                            @if($referDisabled)
                                            <span class="mr-2" data-toggle="tooltip" title="Refer program inactive"><i class="fas fa-question-circle text-muted"></i></span>
                                            @endif
                                            <i class="fas fa-users text-info"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-block shadow font-weight-bold br-10" wire:loading.attr="disabled">
                                <span wire:loading.remove>Confirm Custom Order</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function initializeTooltips() {
        if (window.jQuery && $.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
        }
    }
    document.addEventListener('livewire:navigated', initializeTooltips);
    document.addEventListener('DOMContentLoaded', initializeTooltips);
    Livewire.hook('morph.updated', initializeTooltips);
</script>