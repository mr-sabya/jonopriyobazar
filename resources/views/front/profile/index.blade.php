@extends('front.layouts.app')

@section('title', 'Profile')

@section('content')

<!-- END MAIN CONTENT -->
<div class="main_content">

    <div class="section small_pt pb-0">
        <div class="custom-container">
            <div class="row profile-row">

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-lg-3">
                            @include('front.profile.partials.profile')
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-3">
                                    @include('front.profile.partials.menu')
                                </div>
                                <div class="col-lg-9 pt-3">
                                    <h2>My Profile</h2>
                                    <div class="row">

                                        <div class="col-lg-12 mt-3">
                                            <div class="profile-card p-3">
                                                <div class="profile-header">
                                                    <p>Address Book | <a class="text-success" href="{{ route('user.address.index')}}">Edit</a></p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p style="color: #000">Default Shipping Address</p>
                                                        @if($shipping_address)
                                                        <p style="color: #000" class="m-0 p-0">
                                                            <strong>{{ $shipping_address->name }}</strong> -
                                                            {{ $shipping_address->phone }}<br>
                                                            <span style="font-size: 13px; line-height: 12px">{{ $shipping_address->street }}, {{ $shipping_address->city['name'] }} - {{ $shipping_address->post_code }}, {{ $shipping_address->thana['name']}}, {{ $shipping_address->district['name']}}</span>
                                                        </p>

                                                        <span class="badge badge-warning">
                                                            @if($shipping_address->type == 'home')
                                                            Home
                                                            @elseif($shipping_address->type == 'office')
                                                            Office
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-6">
                                                        <p style="color: #000">Default Billing Address</p>
                                                        @if($billing_address)
                                                        <p style="color: #000" class="m-0 p-0">
                                                            <strong>{{ $billing_address->name }}</strong> -
                                                            {{ $billing_address->phone }}<br>
                                                            <span style="font-size: 13px; line-height: 12px">{{ $billing_address->street }}, {{ $billing_address->city['name'] }} - {{ $billing_address->post_code }}, {{ $billing_address->thana['name']}}, {{ $billing_address->district['name']}}</span>
                                                        </p>

                                                        <span class="badge badge-warning">
                                                            @if($billing_address->type == 'home')
                                                            Home
                                                            @elseif($billing_address->type == 'office')
                                                            Office
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3">
                                            <div class="profile-card p-3">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="profile-header">
                                                            <p>Update Profile</p>
                                                        </div>
                                                        <form id="info_form" action="{{ route('user.info.update')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                            <div class="form-group">
                                                                <label>Phone <span style="color: red">(Unchnaged)</span></label>
                                                                <input type="text" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                                                                <small style="color: red" id="phone_error"></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
                                                                <small style="color: red" id="name_error"></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" name="username" id="username" class="form-control" value="{{ Auth::user()->username }}">
                                                                <small style="color: red" id="username_error"></small>
                                                            </div>


                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-header">
                                                            <p>Update Password</p>
                                                        </div>
                                                        <form id="password_form" action="{{ route('user.password.update')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                            <div class="form-group">
                                                                <label>Current Password</label>
                                                                <input type="password" name="c_password" id="c_password" class="form-control">
                                                                <small style="color: red" id="c_password_error"></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>New Password</label>
                                                                <input type="password" name="password" id="password" class="form-control">
                                                                <small style="color: red" id="password_error"></small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Confirm Password</label>
                                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                                                <small style="color: red" id="confirm_password_error"></small>
                                                            </div>


                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>



                            </div>
                        </div>
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
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>
    $('#image').dropify();

    function copyCode() {
        /* Get the text field */
        var copyText = $('#code').html();
        navigator.clipboard.writeText(copyText);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Your refer code is copied!',
            showConfirmButton: false,
            timer: 1500
        })

    }


    $('#edit_image').click(function(event) {
        $('#profile_image').hide();
        $('#image_upload').show();
    });

    $('#close_edit').click(function(event) {
        $('#image_upload').hide();
        $('#profile_image').show();
    });

    $(document).on('submit','#image_form',function(e){
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
                if (data.errors) {
                    $('#image_error').html(data.errors.image);
                }
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        location.reload();
                    });
                }
            }
        })
    });

    $(document).on('submit','#info_form',function(e){
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
                if (data.errors) {
                    $('#name_error').html(data.errors.name);
                    $('#username_error').html(data.errors.username);
                }
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        })
    });


    $('#c_password').keyup(function(event) {
        if($(this).val() != ''){
            $('#c_password_error').html('');
        }
    });

    $('#password').keyup(function(event) {
        if($(this).val() != ''){
            $('#password_error').html('');
        }
    });

    $('#confirm_password').keyup(function(event) {
        if($(this).val() != ''){
            $('#confirm_password_error').html('');
        }
    });


    $(document).on('submit','#password_form',function(e){
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
                if (data.errors) {
                    $('#c_password_error').html(data.errors.c_password);
                    $('#password_error').html(data.errors.password);
                    $('#confirm_password_error').html(data.errors.confirm_password);
                }
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        })
    });

</script>

@endsection

