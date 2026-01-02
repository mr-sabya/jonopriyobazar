@extends('layouts.front')

@section('title', 'Address Book')

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
                                    <h2>Address</h2>
                                    <div class="profile-card mt-3 p-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Phone Number</th>
                                                    <th>Default Shipping</th>
                                                    <th>Default Billing</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($addresses)>0)
                                                @foreach($addresses as $address)
                                                <tr>
                                                    <td>{{ $address->name }}</td>
                                                    <td>
                                                        {{ $address->street }}, {{ $address->city['name']}}-{{ $address->post_code }}, {{ $address->thana['name']}}, {{ $address->district['name']}}<br>
                                                        @if($address->type == 'home')
                                                        <span class="badge badge-primary">Home</span>
                                                        @elseif($address->type == 'office')
                                                        <span class="badge badge-primary">Office</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $address->phone }}</td>
                                                    <td>
                                                        <div class="address-toggle">
                                                            <label class="toggle-control">
                                                                <input class="is_shipping" type="checkbox" data-id="{{ $address->id }}" {{ $address->is_shipping == 1 ? 'checked' : '' }}>
                                                                <span class="control"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="address-toggle">
                                                            <label class="toggle-control">
                                                                <input class="is_billing" type="checkbox" data-id="{{ $address->id }}" {{ $address->is_billing == 1 ? 'checked' : '' }}>
                                                                <span class="control"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('user.address.edit', $address->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="6"><center>No Address found</center></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <a href="{{ route('user.address.create')}}" class="btn btn-primary" id="add_address">+ Add Address</a>
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
    $(document).on('click', '.is_billing', function () {
        $('.is_billing').prop('checked', false);
        
        var this_btn = $(this);
        var address_id = $(this).attr('data-id');
        $.ajax({
            url: "/customer/set-billing-address/"+address_id,
            method: "GET",   
            success: function (data) {

                if (data.success) {
                    this_btn.prop('checked', true);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });

                }

                if(data.error){
                    this_btn.prop('checked', true);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: data.error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

            }
        })
    });


    $(document).on('click', '.is_shipping', function () {
        $('.is_shipping').prop('checked', false);
        var this_btn = $(this);
        var address_id = $(this).attr('data-id');
        $.ajax({
            url: "/customer/set-shipping-address/"+address_id,
            method: "GET",   
            success: function (data) {

                if (data.success) {
                    this_btn.prop('checked', true);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });

                }

                if(data.error){
                    this_btn.prop('checked', true);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: data.error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

            }
        })
    });
</script>

@endsection

