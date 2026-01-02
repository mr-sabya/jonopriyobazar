@extends('layouts.front')

@section('title')
Forgot Password
@endsection

@section('link')
<li class="breadcrumb-item active">Forgot Password</li>
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
                                <h3>Forgot Password?</h3>
                                <small style="color: red" id="code_error"></small>
                            </div>
                            <form method="post" id="login_form" action="{{ route('phone.find')}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" placeholder="Your Phone Number" id="login_phone" autocomplete="new-phone">
                                    <small style="color: red" id="login_phone_error"></small>
                                </div>
                               
                            
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">Find Your Phone Number</button>
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



    $('#login_phone').keyup(function(event) {
        if($(this).val() != ''){
            $('#login_phone_error').html('');
        }
    });

   

    $(document).on('submit','#login_form',function(e){
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
                    $('#login_phone_error').html(data.errors.phone);
                }

                
                if(data.error){
                    $('#code_error').html(data.error);
                }

                if (data.success) {
                    window.location = data.success;
                }


            }
        })


    });
</script>

@endsection