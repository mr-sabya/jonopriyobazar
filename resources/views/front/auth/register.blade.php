@extends('layouts.front')

@section('title')
Register
@endsection

@section('link')
<li class="breadcrumb-item active">Register</li>
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>Create an Account</h3>
                            </div>
                            <form method="post" action="{{ route('register.submit')}}" id="register_form">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Your Full Name*">
                                    <small style="color: red" id="name_error"></small>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" placeholder="Your Phone Number*" autocomplete="new-phone">
                                    <small style="color: red" id="phone_error"></small>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Password*" autocomplete="new-password">
                                    <small style="color: red" id="password_error"></small>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="test" name="ref_code" placeholder="Reference Code">
                                    <small style="color: red" id="ref_code_error"></small>
                                </div>
                                
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                            <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="register">Register</button>
                                </div>
                            </form>

                            <div class="different_login">
                                <span> or</span>
                            </div>
                            <div class="form-note text-center"><a href="{{ route('login')}}">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')

<script>
    $(document).on('submit','#register_form',function(e){
        event.preventDefault();
        // ============ for create ==========================================================

        $.ajax({
            url: $(this).prop('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                

                if (data.errors) {
                    $('#name_error').html(data.errors.name);
                    $('#phone_error').html(data.errors.phone);
                    $('#password_error').html(data.errors.password);
                    $('#ref_code_error').html(data.errors.ref_code);
                }
                if(data.phone){
                    window.location = "{{ route('verify.form') }}"+"?phone="+data.phone;
                }

            }
        })


    });
</script>

@endsection