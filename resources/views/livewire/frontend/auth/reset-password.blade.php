<div class="login_register_wrap section auth-bg-gradient">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="login_wrap animate-up">
                    <div class="padding_eight_all p-4 p-md-5">
                        <div class="heading_s1 text-center mb-4">
                            <h2 class="mb-2" style="font-weight: 800; color: #1a1a1a; letter-spacing: -1px;">Set New Password</h2>
                            <p class="text-muted">Resetting password for <span class="fw-bold text-dark">{{ $phone }}</span></p>
                        </div>

                        <form wire:submit.prevent="changePassword">
                            <!-- New Password -->
                            <!-- New Password -->
                            <div class="form-group mb-3">
                                <label class="small fw-bold text-uppercase text-muted mb-2">New Password</label>
                                <div class="password-wrapper" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'"
                                        class="form-control @error('password') is-invalid @enderror"
                                        wire:model="password"
                                        placeholder="••••••••">

                                    <button type="button" class="password-toggle" @click="show = !show">
                                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Confirm New Password</label>
                                <div class="password-wrapper" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'"
                                        class="form-control"
                                        wire:model="password_confirmation"
                                        placeholder="••••••••">

                                    <button type="button" class="password-toggle" @click="show = !show">
                                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-login btn-block text-white w-100">
                                    <span wire:loading.remove wire:target="changePassword">
                                        Update Password <i class="ti-check-box ms-2"></i>
                                    </span>
                                    <span wire:loading wire:target="changePassword">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Updating...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="form-note text-center mt-4">
                            <a href="{{ route('login') }}" wire:navigate class="text-muted small">
                                <i class="ti-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>