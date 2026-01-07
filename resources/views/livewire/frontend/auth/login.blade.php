<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap shadow-sm rounded">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Login</h3>
                            @error('otp_error')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Livewire Submit -->
                        <form wire:submit.prevent="login">
                            <div class="form-group">
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    wire:model.defer="phone"
                                    placeholder="Your Phone Number">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    wire:model.defer="password"
                                    placeholder="Password">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" wire:model="remember" id="exampleCheckbox1">
                                        <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                    </div>
                                </div>
                                <a href="{{ route('forgot.password')}}">Forgot password?</a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block bg-main-green text-white" name="login">
                                    <span wire:loading.remove wire:target="login">Log in</span>
                                    <span wire:loading wire:target="login">Processing...</span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login">
                            <span> or</span>
                        </div>

                        <div class="form-note text-center">
                            <a href="{{ route('register')}}" wire:navigate>Create A New Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>