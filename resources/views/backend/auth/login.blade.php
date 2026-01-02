@extends('layouts.backauth')

@section('title', 'Login')

@section('content')

<div class="authentication">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="header">
                        <img class="logo" src="{{ url('backend/images/logo.png') }}" alt="">
                        <h5>Log in</h5>
                    </div>
                    <div class="body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Email" name="email">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                </div>

                            </div>
                            @if ($errors->has('email'))
                            <span id="title_error" style="color: red">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <div class="input-group-append">                                
                                    <span class="input-group-text"><a href="forgot-password.html" class="forgot" title="Forgot Password"><i class="zmdi zmdi-lock"></i></a></span>
                                </div>

                            </div>
                            @if ($errors->has('password'))
                            <span id="title_error" style="color: red">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="checkbox">
                            <input id="remember_me" type="checkbox" name="remember">
                            <label for="remember_me">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN IN</button>                        
                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection