<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap shadow-sm">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Create an Account</h3>
                            @error('otp_error') <small style="color: red">{{ $message }}</small> @enderror
                        </div>

                        <form wire:submit.prevent="register">
                            <div class="form-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    wire:model.defer="name" placeholder="Your Full Name*">
                                @error('name') <small style="color: red">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    wire:model.defer="phone" placeholder="Your Phone Number*" autocomplete="new-phone">
                                @error('phone') <small style="color: red">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('password') is-invalid @enderror"
                                    type="password" wire:model.defer="password" placeholder="Password*" autocomplete="new-password">
                                @error('password') <small style="color: red">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('ref_code') is-invalid @enderror"
                                    type="text" wire:model.defer="ref_code" placeholder="Reference Code (Optional)">
                                @error('ref_code') <small style="color: red">{{ $message }}</small> @enderror
                            </div>

                            <div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" wire:model="agree" id="exampleCheckbox2">
                                        <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                    </div>
                                    @error('agree') <small class="d-block" style="color: red">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block bg-main-green text-white" name="register">
                                    <span wire:loading.remove wire:target="register">Register</span>
                                    <span wire:loading wire:target="register">Creating Account...</span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login">
                            <span> or</span>
                        </div>
                        <div class="form-note text-center"><a href="{{ route('login')}}" wire:navigate>Already have an account? Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>