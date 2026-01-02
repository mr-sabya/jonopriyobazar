@extends('layouts.front')

@section('title', 'Address')

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
                                    <h2>Add New Address</h2>
                                    <div class="profile-card mt-3 p-3">
                                        <form id="address_form" action="{{ route('user.address.store')}}" method="post">
                                            @csrf
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
                                                        <label for="city_id">City/Area</label>
                                                        <select name="city_id" id="city_id" class="form-control">
                                                            <option value="" selected disabled>--select city/area--</option>
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


                                            <div class="form-group pl-3 pt-lg-5">
                                                <button type="submit" class="btn btn-primary">SAVE</button>
                                            </div>

                                        </div>
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



<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>
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

    $(document).on('submit','#address_form',function(e){
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
                    $('#address_phone_error').html(data.errors.phone);
                    $('#street_error').html(data.errors.street);
                    $('#district_id_error').html(data.errors.district_id);
                    $('#thana_id_error').html(data.errors.thana_id);
                    $('#city_id_error').html(data.errors.city_id);
                    $('#post_code_error').html(data.errors.post_code);
                    $('#type_error').html(data.errors.type);
                    
                }
                if (data.route) {

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'New addess is added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        console.log(data.success);
                        window.location.href = data.route;
                    });

                    
                }

            }
        })


    });
</script>

@endsection

