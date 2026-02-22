<div class="login_register_wrap section" style="background: #f0f4f3; min-height: 90vh; display: flex; align-items: center; padding: 40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="login_wrap animate-up">
                    <div class="padding_eight_all p-4 p-md-5">
                        <div class="heading_s1 text-center mb-5">
                            <h2 class="mb-2" style="font-weight: 800; color: #1a1a1a; letter-spacing: -1px;">Welcome Back</h2>
                            <p class="text-muted">Enter your credentials to access your account</p>
                            @error('otp_error')
                            <div class="alert alert-danger py-2 border-0 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <form wire:submit.prevent="login">
                            <!-- Phone Field -->
                            <div class="form-group mb-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Phone Number</label>
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    wire:model="phone"
                                    placeholder="e.g. 017XXXXXXXX">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Password</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    wire:model="password"
                                    placeholder="••••••••">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Footer Actions -->
                            <div class="login_footer form-group mb-4 d-flex justify-content-between align-items-center">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" wire:model="remember" id="exampleCheckbox1">
                                        <label class="form-check-label" for="exampleCheckbox1"><span class="text-muted">Remember me</span></label>
                                    </div>
                                </div>
                                <a href="{{ route('forgot.password')}}" wire:navigate class="small fw-bold text-decoration-none" style="color: var(--main-green);">Forgot password?</a>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-login btn-block text-white w-100">
                                    <span wire:loading.remove wire:target="login">
                                        Log in <i class="ti-arrow-right ms-2"></i>
                                    </span>
                                    <span wire:loading wire:target="login">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Checking...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login">
                            <span>Or</span>
                        </div>

                        <div class="form-note text-center">
                            <span class="text-muted">New to our platform?</span>
                            <a href="{{ route('register')}}" wire:navigate class="fw-bold ms-1" style="color: var(--main-green); text-decoration: none;">
                                Create An Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>