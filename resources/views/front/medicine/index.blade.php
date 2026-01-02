@extends('layouts.front')

@section('title')
Medicine Order
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="custom-container custom-order">
            <div class="row">
                <div class="col-lg-12">
                    <div class="custom-order-title">
                        <h2>Medicine Order form</h2>
                        
                        <p>মেডিসিন অর্ডার ফরমের মাধ্যমে আপনার প্রেসক্রিপশন-এর ছবি আপলোড করে ঔষধ অর্ডার করতে পারবেন</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <form action="{{ route('medicine.store')}}" id="custom_order_form" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(!$shipping_address)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-row border-bottom mb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" id="name" class="form-control">
                                                    <small style="color: red" id="name_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">Phone</label>
                                                    <input type="text" name="phone" id="address_phone" class="form-control">
                                                    <small style="color: red" id="address_phone_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="street">Address</label>
                                                    <input type="text" class="form-control" id="street" name="street" placeholder="House no.1, Road no. 1, Sonadanga">
                                                    <small style="color: red" id="street_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="district_id">District</label>
                                                    <select name="district_id" id="district_id" class="form-control">
                                                        <option value="" selected disabled>--select district--</option>
                                                        @foreach ($districts as $district)
                                                        <option value="{{ $district->id}}">{{ $district->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small style="color: red" id="district_id_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group ">
                                                    <label for="thana_id">Thana</label>
                                                    <select name="thana_id" id="thana_id" class="form-control">
                                                        <option value="" selected disabled>--select thana--</option>
                                                    </select>
                                                    <small style="color: red" id="thana_id_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="city_id">city</label>
                                                    <select name="city_id" id="city_id" class="form-control">
                                                        <option value="" selected disabled>--select city--</option>
                                                    </select>
                                                    <small style="color: red" id="city_id_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="post_code">Post Code</label>
                                                    <input type="text" class="form-control" id="post_code" name="post_code" placeholder="Enter post code">
                                                    <small style="color: red" id="post_code_error"></small>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="middle">
                                                    <label>
                                                        <input value="home" type="radio" name="type" checked/>
                                                        <div class="front-end box">
                                                            <span>
                                                                <i class="fas fa-home"></i><br>
                                                                Home
                                                            </span>
                                                        </div>
                                                    </label>
                                                    <label>
                                                        <input value="office" type="radio" name="type"/>
                                                        <div class="back-end box">
                                                            <span>
                                                                <i class="fas fa-briefcase"></i><br>Office
                                                            </span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <small style="color: red" id="type_error"></small>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @else
                                <div class="address">
                                    <div class="default-address">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h6>Default Shipping Address</h6>
                                                <div class="point">
                                                    <div class="icon">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </div>
                                                    <div class="text">
                                                        <p><span>{{ $shipping_address->name}}</span><br>
                                                            {{ $shipping_address->street }}<br>
                                                            {{ $shipping_address->city['name'] }} - {{ $shipping_address->post_code }}, {{ $shipping_address->thana['name'] }}, {{ $shipping_address->district['name'] }}<br>
                                                            <strong>{{ $shipping_address->phone }}</strong>

                                                        </p>
                                                    </div>
                                                    <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="{{ $shipping_address->id }}">

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h6>Default Billing Address</h6>
                                                <div class="point">
                                                    <div class="icon">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </div>
                                                    <div class="text">
                                                        <p><span>{{ $billing_address->name}}</span><br>
                                                            {{ $billing_address->street }}<br>
                                                            {{ $billing_address->city['name'] }} - {{ $billing_address->post_code }}, {{ $billing_address->thana['name'] }}, {{ $billing_address->district['name'] }}<br>
                                                            <strong>{{ $billing_address->phone }}</strong>

                                                        </p>
                                                    </div>
                                                    <input type="hidden" name="billing_address_id" id="billing_address_id" value="{{ $billing_address->id }}">

                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <hr>
                                @endif


                                <div class="row mt-5">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Prescription</label>
                                                    <input type="file" name="image" class="form-control" id="image">
                                                    <small style="color: red" id="image_error"></small>
                                                </div>

                                                <div class="form-group">
                                                    <label>Order List</label>
                                                    <textarea class="form-control" name="custom" id="custom" placeholder="Enter your medicine list in serial (1, 2, 3) with quantity.." rows="5" cols="60"></textarea>
                                                    <small style="color: red" id="custom_error"></small>
                                                </div>
                                                

                                                
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <div class="payment_option">
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_option" id="cash_on_delivery" value="cash" checked="">
                                                <label class="form-check-label" for="cash_on_delivery">Cash On Delivery</label>

                                            </div>

                                            @if(Auth::user()->is_wallet == 1)

                                            @if(Auth::user()->is_hold == 1)
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet" disabled>
                                                <label class="form-check-label" for="wallet_radio">Credit Wallet id Hold</label>

                                            </div>
                                            @elseif(Auth::user()->is_expired == 1)
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet" disabled>
                                                <label class="form-check-label" for="wallet_radio">Credit Wallet id Expired</label>

                                            </div>
                                            @else
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet">
                                                <label class="form-check-label" for="wallet_radio">Credit Wallet</label>

                                            </div>
                                            @endif
                                            @endif

                                            @if(Auth::user()->is_percentage == 1)
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="payment_option" id="percentage_radio" value="reffer" >
                                                <label class="form-check-label" for="percentage_radio">Reffer Wallet</label>
                                            </div>
                                            @else
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="payment_option" id="percentage_radio" value="reffer" disabled>
                                                <label class="form-check-label" for="percentage_radio">Reffer Wallet</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="col-lg-12 mt-3">
                                        <div class="form-group">                                            
                                            <button class="btn btn-success w-100" type="submit"> Order Now</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->


</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('frontend/summernote/summernote-lite.min.js')}}"></script>
<script>

    $('#image').change(function(event) {
        $('#image_error').html('');
    });


    $('#custom').summernote({
        placeholder: 'Enter your medicine list in serial (1, 2, 3) with quantity..',
        height: 200,
        toolbar: false,
        callbacks: {
            onKeyup: function(e) {
                setTimeout(function(){
                    $("#custom_error").html('');
                });
            }
        }
    });

    $('#district_id').change(function(event) {
        var id = $(this).val();
        $.ajax({
            url: '/get-thana/'+id,
            type: 'get',
            success:function(data){
                if(data.thana == ''){
                    $('#thana_id').html('');
                    $('#thana_id').append('<option value="">No Thana Found</option>');
                }else{
                    $('#thana_id').html('');
                    $('#thana_id').append('<option value="" selected disabled>(Select Thana)</option>');
                    $('#thana_id').append(data.thana);
                }
                
            }
            
        });
    });

    $('#thana_id').change(function(event) {
        var id = $(this).val();
        $.ajax({
            url: '/get-city/'+id,
            type: 'get',
            success:function(data){
                if(data.thana == ''){
                    $('#city_id').html('');
                    $('#city_id').append('<option value="">No City Found</option>');
                }else{
                    $('#city_id').html('');
                    $('#city_id').append('<option value="" selected disabled>(Select City)</option>');
                    $('#city_id').append(data.city);
                }
                
            }
            
        });
    });

    $(document).on('submit','#custom_order_form',function(e){
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
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Please complete the required field!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    $('#custom_error').html(data.errors.custom);
                    $('#image_error').html(data.errors.image);


                    $('#name_error').html(data.errors.name);
                    $('#address_phone_error').html(data.errors.phone);
                    $('#street_error').html(data.errors.street);
                    $('#district_id_error').html(data.errors.district_id);
                    $('#thana_id_error').html(data.errors.thana_id);
                    $('#city_id_error').html(data.errors.city_id);
                    $('#post_code_error').html(data.errors.post_code);
                    $('#type_error').html(data.errors.type);
                    
                }
                if (data.success) {
                    $('#custom_order_form')[0].reset();
                    $('#custom').summernote('code', '');
                    $('image_error').html('');
                    $('custom_error').html('');

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