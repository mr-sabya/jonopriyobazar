@extends('layouts.front')

@section('title')
Verify
@endsection

@section('link')
<li class="breadcrumb-item active">Veriry</li>
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
                                <h3>Verify</h3>
                            </div>
                            
                            <form id="verify_form" action="{{ route('verify.submit')}}" method="POST">

                                @csrf
                                @if(isset($_GET['phone']))
                                <input type="hidden" name="phone" id="phone" value="{{ $_GET['phone'] }}">
                                @endif

                                <div class="userinput">
                                    <input name="code_1" type="text" id='ist' maxlength="1" onkeyup="clickEvent(this,'sec')">
                                    <input name="code_2" type="text" id="sec" maxlength="1" onkeyup="clickEvent(this,'third')">
                                    <input name="code_3" type="text" id="third" maxlength="1" onkeyup="clickEvent(this,'fourth')">
                                    <input name="code_4" type="text" id="fourth" maxlength="1">
                                </div>
                                <div class="text-center"><small style="color: red;" id="code_error"></small></div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">Submit</button>
                                </div>
                            </form>
                            

                            <div class="different_login">
                                <span> If you don't get OTP</span>
                            </div>

                            <div class="form-note text-center"><a href="{{ route('register')}}">Resend OTP</a></div>
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

    function clickEvent(first,last){
        if(first.value.length){
            document.getElementById(last).focus();
        }
    }

    $(document).on('submit','#verify_form',function(e){
        event.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {


                if (data.code) {
                    $('#code_error').html(data.code);
                }
                if (data.success) {
                    console.log(data.success);
                    window.location = "{{ route('home')}}";
                }

            }
        })


    });
</script>

@endsection