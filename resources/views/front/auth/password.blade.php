@extends('layouts.front')

@section('title')
New Password
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
                                <h3>Reset Password</h3>
                            </div>
                            <form method="post" action="{{ route('reset.password.submit')}}" id="register_form">
                                @csrf

                                <h3 class="text-center">Reset password for <br>
                                    <span style="color: #339CFF">{{ $user->phone }}</span>
                                </h3>
                                
                                <input type="hidden" name="phone" value="{{ $user->phone }}">
                                <div class="form-group">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="New Password*" autocomplete="new-password">
                                    <small style="color: red" id="password_error"></small>
                                </div>


                                <div class="form-group">
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password*" autocomplete="new-password">
                                    <small style="color: red" id="c_password_error"></small>
                                    <small style="color: green" id="c_password_success"></small>
                                </div>

                                
                                
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="register">Change Password</button>
                                </div>
                            </form>

                            
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

    $('#confirm_password').keyup(function(event) {
        var password = $('#password').val();

        var confirm_password = $(this).val();

        if(password == confirm_password){
            $('#c_password_error').html('');

            $('#c_password_success').html('Confirm password match');
        }else{
            $('#c_password_success').html('');
            
            $('#c_password_error').html('Confirm password does not match');
        }
    });


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
                    
                    $('#password_error').html(data.errors.password);
                    
                }
                if(data.success){
                    window.location = data.success;
                }

            }
        })


    });
</script>

@endsection