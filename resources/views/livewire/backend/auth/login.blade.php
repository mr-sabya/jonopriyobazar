<div class="authentication">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" wire:submit.prevent="login">
                    <div class="header">
                        <img class="logo" src="{{ url('backend/images/logo.png') }}" alt="">
                        <h5>Log in</h5>
                    </div>

                    <div class="body">
                        <!-- Session Flash Messages -->
                        @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Email" wire:model="email">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>
                            </div>
                            @error('email')
                            <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" wire:model="password">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <a href="#" class="forgot" title="Forgot Password"><i class="zmdi zmdi-lock"></i></a>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                            <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="checkbox">
                            <input id="remember_me" type="checkbox" wire:model="remember">
                            <label for="remember_me">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">
                            <span wire:loading.remove wire:target="login">SIGN IN</span>
                            <span wire:loading wire:target="login">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>