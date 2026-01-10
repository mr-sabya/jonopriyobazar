<div class="col-lg-8 col-xl-9">

    <!-- 1. ADDRESS SUMMARY CARD -->
    <div class="card border-0 shadow-sm br-15 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="section-title mb-0">Address Book</h5>
                <a href="{{ route('user.address.index')}}" class="btn btn-outline-success btn-sm br-10" wire:navigate>Manage All</a>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="p-3 rounded bg-light border h-100 position-relative">
                        <span class="badge badge-success position-absolute" style="top:10px; right:10px;">Shipping</span>
                        <h6 class="font-weight-bold small text-muted text-uppercase mb-2">Default Shipping</h6>
                        @if($shipping_address)
                        <p class="font-weight-bold mb-1 text-dark">{{ $shipping_address->name }}</p>
                        <p class="small text-muted mb-2"><i class="fas fa-phone-alt mr-1"></i> {{ $shipping_address->phone }}</p>
                        <p class="small text-dark mb-0 line-height-sm">
                            {{ $shipping_address->street }}, {{ $shipping_address->city->name ?? '' }} - {{ $shipping_address->post_code }}
                        </p>
                        @else
                        <p class="small text-muted font-italic">No shipping address set.</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded bg-light border h-100 position-relative">
                        <span class="badge badge-primary position-absolute" style="top:10px; right:10px;">Billing</span>
                        <h6 class="font-weight-bold small text-muted text-uppercase mb-2">Default Billing</h6>
                        @if($billing_address)
                        <p class="font-weight-bold mb-1 text-dark">{{ $billing_address->name }}</p>
                        <p class="small text-muted mb-2"><i class="fas fa-phone-alt mr-1"></i> {{ $billing_address->phone }}</p>
                        <p class="small text-dark mb-0 line-height-sm">
                            {{ $billing_address->street }}, {{ $billing_address->city->name ?? '' }} - {{ $billing_address->post_code }}
                        </p>
                        @else
                        <p class="small text-muted font-italic">No billing address set.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 2. UPDATE PROFILE FORM -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm br-15 h-100">
                <div class="card-body p-4">
                    <h5 class="section-title">Personal Information</h5>
                    <form wire:submit.prevent="updateInfo">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Phone Number</label>
                            <input type="text" class="form-control br-10 bg-light" value="{{ Auth::user()->phone }}" disabled>
                            <small class="text-muted font-italic" style="font-size:10px;">(Mobile number cannot be changed)</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Full Name</label>
                            <input type="text" wire:model="name" class="form-control br-10 @error('name') is-invalid @enderror">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted">Username</label>
                            <input type="text" wire:model="username" class="form-control br-10 @error('username') is-invalid @enderror">
                            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-success btn-block br-10 shadow-sm font-weight-bold">
                            <span wire:loading.remove wire:target="updateInfo">Update Profile</span>
                            <span wire:loading wire:target="updateInfo">Updating...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. UPDATE PASSWORD FORM -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm br-15 h-100">
                <div class="card-body p-4">
                    <h5 class="section-title">Security & Password</h5>
                    <form wire:submit.prevent="updatePassword">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Current Password</label>
                            <input type="password" wire:model="c_password" class="form-control br-10 @error('c_password') is-invalid @enderror" placeholder="••••••••">
                            @error('c_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">New Password</label>
                            <input type="password" wire:model="password" class="form-control br-10 @error('password') is-invalid @enderror" placeholder="••••••••">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted">Confirm New Password</label>
                            <input type="password" wire:model="confirm_password" class="form-control br-10 @error('confirm_password') is-invalid @enderror" placeholder="••••••••">
                            @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block br-10 shadow-sm font-weight-bold">
                            <span wire:loading.remove wire:target="updatePassword">Change Password</span>
                            <span wire:loading wire:target="updatePassword">Updating...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- 4. TWO-FACTOR AUTHENTICATION -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm br-15 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-shield-alt text-primary fa-lg mr-2"></i>
                        <h5 class="section-title mb-0">Security Options</h5>
                    </div>
                    <p class="small text-muted mb-4">Add an extra layer of security to your account by enabling Two-Factor Authentication.</p>

                    <div class="d-flex align-items-center justify-content-between p-3 bg-light br-10 mb-3">
                        <div>
                            <h6 class="font-weight-bold mb-0">Two-Factor Auth</h6>
                            <small class="text-{{ $two_factor_enabled ? 'success' : 'muted' }}">
                                {{ $two_factor_enabled ? 'Enabled' : 'Disabled' }}
                            </small>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="2faSwitch"
                                wire:click="toggle2FA" {{ $two_factor_enabled ? 'checked' : '' }}>
                            <label class="custom-control-label" for="2faSwitch"></label>
                        </div>
                    </div>

                    <div class="p-3 bg-light br-10">
                        <h6 class="font-weight-bold mb-1 small text-uppercase text-muted">Active Sessions</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class="fas fa-desktop text-muted mr-2"></i>
                            <div class="small">
                                <span class="d-block font-weight-bold">Windows - Chrome Browser</span>
                                <span class="text-muted">Current Session (IP: 103.xxx.xx.x)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. DANGER ZONE -->
        <div class="col-md-6 mb-4">
            <div class="card border-danger-light shadow-sm br-15 h-100" style="background: #fff8f8;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-exclamation-triangle text-danger fa-lg mr-2"></i>
                        <h5 class="section-title text-danger mb-0">Danger Zone</h5>
                    </div>

                    <!-- Deactivate -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-dark mb-1">Deactivate Account</h6>
                        <p class="small text-muted mb-2">Temporarily disable your profile. You can re-enable it by logging in later.</p>
                        <button wire:click="deactivateAccount" wire:confirm="Are you sure you want to deactivate your account?" class="btn btn-outline-danger btn-sm br-10 px-3">Deactivate</button>
                    </div>

                    <hr>

                    <!-- Delete -->
                    <div>
                        <h6 class="font-weight-bold text-danger mb-1">Delete Permanently</h6>
                        <p class="small text-muted mb-3">This action is irreversible. All your data, orders, and history will be wiped.</p>

                        <div class="form-group mb-2">
                            <input type="password" wire:model="delete_password" class="form-control form-control-sm br-10 @error('delete_password') is-invalid @enderror" placeholder="Enter password to confirm">
                            @error('delete_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button wire:click="deleteAccount"
                            wire:confirm="WARNING: This will permanently delete your account. Proceed?"
                            class="btn btn-danger btn-block br-10 font-weight-bold">
                            Delete My Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>