<div class="login_register_wrap section auth-bg-gradient">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="login_wrap animate-up">
                    <div class="padding_eight_all p-4 p-md-5">
                        <div class="heading_s1 text-center mb-4">
                            <h2 class="mb-2" style="font-weight: 800; color: #1a1a1a; letter-spacing: -1px;">Reset Password</h2>
                            <p class="text-muted">Enter your phone number to receive a verification code</p>

                            @error('otp_error')
                            <div class="alert alert-danger py-2 border-0 small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <form wire:submit.prevent="sendOtp">
                            <div class="form-group mb-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Phone Number</label>
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    wire:model="phone"
                                    placeholder="e.g. 017XXXXXXXX"
                                    autocomplete="off">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-login btn-block text-white w-100">
                                    <span wire:loading.remove wire:target="sendOtp">
                                        Send Code <i class="ti-arrow-right ms-2"></i>
                                    </span>
                                    <span wire:loading wire:target="sendOtp">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Sending...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login">
                            <span>Or</span>
                        </div>

                        <div class="form-note text-center">
                            <span class="text-muted">Remembered your password?</span>
                            <a href="{{ route('login')}}" wire:navigate class="fw-bold ms-1" style="color: var(--shwapno-green); text-decoration: none;">
                                Login Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>