<div class="login_register_wrap section" style="background: #f0f4f3; min-height: 90vh; display: flex; align-items: center; padding: 40px 0;">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="login_wrap animate-up">
                    <div class="padding_eight_all p-4 p-md-5">
                        <div class="heading_s1 text-center mb-5">
                            <h2 class="mb-2" style="font-weight: 800; color: #1a1a1a; letter-spacing: -1px;">Join Us</h2>
                            <p class="text-muted">Create your account and start shopping</p>
                            @error('otp_error')
                            <div class="alert alert-danger py-2 border-0 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <form wire:submit.prevent="register">
                            <!-- Name Field -->
                            <div class="form-group mb-3">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Full Name</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    wire:model.defer="name"
                                    placeholder="Enter your name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="form-group mb-3">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Phone Number</label>
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    wire:model.defer="phone"
                                    placeholder="e.g. 017XXXXXXXX"
                                    autocomplete="new-phone">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-3">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Password</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    wire:model.defer="password"
                                    placeholder="Minimum 6 characters"
                                    autocomplete="new-password">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Reference Code -->
                            <div class="form-group mb-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Reference Code (Optional)</label>
                                <input type="text"
                                    class="form-control @error('ref_code') is-invalid @enderror"
                                    wire:model.defer="ref_code"
                                    placeholder="Enter code if any">
                                @error('ref_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="login_footer form-group mb-4">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" wire:model="agree" id="exampleCheckbox2">
                                        <label class="form-check-label" for="exampleCheckbox2">
                                            <span class="text-muted">I agree to the <a href="#" class="text-decoration-none" style="color: var(--main-green);">Terms &amp; Policy</a></span>
                                        </label>
                                    </div>
                                    @error('agree') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-login btn-block text-white w-100">
                                    <span wire:loading.remove wire:target="register">
                                        Create Account <i class="ti-user ms-2"></i>
                                    </span>
                                    <span wire:loading wire:target="register">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login">
                            <span>Or</span>
                        </div>

                        <div class="form-note text-center">
                            <span class="text-muted">Already have an account?</span>
                            <a href="{{ route('login')}}" wire:navigate class="fw-bold ms-1" style="color: var(--main-green); text-decoration: none;">
                                Login Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>