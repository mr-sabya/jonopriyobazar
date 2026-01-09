@extends('front.layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/dropify/css/dropify.min.css') }}">
@endsection

@section('title', 'Wallet')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">

            <div class="row">
                
                <div class="col-md-6">

                    <div class="heading_s1">
                        <h4>Wallet</h4>
                    </div>
                    <div class="row wallet">
                        <div class="col-6">
                            <a href="{{ route('user.wallet.show')}}">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-wallet"></i>
                                        <h2>{{ Auth::user()->wallet_balance }} ৳</h2>
                                        <p>Credit Balance</p>
                                    </div>

                                    @if(Auth::user()->is_hold == 0)

                                    @if(Auth::user()->is_expired == 1)
                                    <div class="date" style="background: #ff0000">
                                        <p>Credit Wallet Package Expired!</p>
                                    </div>
                                    @else
                                    <div class="date">
                                        @if($active_package)
                                        <p>Exprire On : {{ date('d-m-Y h:i A', strtotime($active_package->valid_to))}}</p>
                                        @else
                                        <p>Wallet is not Active</p>
                                        @endif
                                        
                                    </div>
                                    @endif
                                    @elseif(Auth::user()->is_hold == 1)
                                    <div class="date" style="background: #ff0000">
                                        <p>Credit Wallet id Hold</p>
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.refer.balance')}}">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-friends"></i>
                                        <h2>{{ Auth::user()->ref_balance }} ৳</h2>
                                        <p>Referrence Balance</p>
                                    </div>
                                    <div class="date">
                                        <p> Only For Sale Price</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.point.index')}}">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-trophy"></i>
                                        <h2>{{ Auth::user()->point }}</h2>
                                        <p>Point</p>
                                    </div>
                                    <div class="date">
                                        <p>Get Prize Only</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.refer.index')}}">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users"></i>
                                        <h2>{{ Auth::user()->refers->count() }}</h2>
                                        <p>Total Reference</p>
                                    </div>
                                    <div class="date">
                                        <p>Refer More Earn More</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">


                    <div id="request_success_top" style="display: none;"> 
                        <div class="heading_s1">
                            <h4>Credit Wallet</h4>
                        </div>
                        <div class="card">
                            <div class="request">
                                <i class="fas fa-check"></i>
                                <h3>Thanks you for your Request! We will contact you soon!</h3>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->is_wallet == 0)
                    @if(Auth::user()->wallet_request == 1)
                    <div id="request_success">

                        <div class="heading_s1">
                            <h4>Credit Wallet</h4>
                        </div>
                        <div class="card">
                            <div class="request">
                                <i class="fas fa-check"></i>
                                <h3>Thanks you for your Request! We will contact you soon!</h3>
                                @if(Auth::user()->wallet_request == 1)
                                <span class="badge badge-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                        <!-- <a href="">Calcel Request</a> -->

                    </div>
                    @else
                    <div id="request">
                        <div class="heading_s1">
                            <h4>Apply for wallet</h4>
                        </div>
                        <div class="cupon">
                            <div class="toggle_info">
                                <span><i class="fas fa-tag"></i>Want to create credit wallet? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to apply</a></span>
                            </div>
                            <div class="panel-collapse collapse coupon_form" id="coupon">
                                <div class="panel-body" style="position: relative;">
                                    <div id="loader" class="loader-popup" style="display: none;">
                                        <img src="{{ url('backend/images/loader.gif')}}">
                                        <h4>Uploading....</h4>
                                    </div>
                                    <form id="wallet_form" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ Auth::user()->id}}">
                                        <div class="form-group">
                                            <label>Nation ID Image (Front)</label>
                                            <input type="file" name="n_id_front" id="n_id_front" @if(Auth::user()->n_id_front != '')data-default-file="{{ url('upload/images', Auth::user()->n_id_front)}}" @endif>
                                            <small style="color: red" id="n_id_front_error"></small>
                                        </div>

                                        <div class="form-group">
                                            <label>Nation ID Image (Back)</label>
                                            <input type="file" name="n_id_back" id="n_id_back" @if(Auth::user()->n_id_back != '')data-default-file="{{ url('upload/images', Auth::user()->n_id_back)}}" @endif>
                                            <small style="color: red" id="n_id_back_error"></small>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-fill-out btn-sm" type="submit">Apply</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="heading_s1">
                        <h4>Credit Wallet Packages</h4>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                @foreach($packages as $package)
                                <tr>
                                    <td>Package - {{ $loop->index + 1 }}</td>
                                    <td>{{ $package->amount }} - {{ $package->validate }} Days</td>
                                    <td class="text-center">


                                        @if(Auth::user()->applyWallet($package->id))
                                        @if(Auth::user()->wallet_package_id != null)
                                        @if(Auth::user()->wallet_package_id == $package->id)
                                        <span class="badge badge-success p-3"><i class="fas fa-check"></i> Active</span>
                                        
                                        @endif
                                        @else
                                        <button class="apply btn btn-primary" data-id="{{ $package->id }}" disabled>Applied</button>
                                        @endif
                                        
                                        @else

                                        @if(Auth::user()->wallet_package_id == null)
                                        <button class="apply btn btn-primary" data-id="{{ $package->id }}">Apply</button>
                                        @endif
                                        @endif



                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif

                </div>
            </div>

            
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script src="{{ asset('frontend/dropify/js/dropify.min.js') }}"></script>

<script>
    $('#n_id_front').dropify();
    $('#n_id_back').dropify();

    $('#wallet_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('user.wallet.apply') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function(){
                $('#loader').show();
            },
            success: function (data) {
                $('#loader').hide();
                if (data.errors) {
                    $('#n_id_front_error').html(data.errors.n_id_front);
                    $('#n_id_back_error').html(data.errors.n_id_back);
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

                    $('#request').hide();
                    $('#request_success_top').show();

                }

            }
        })

    });

    $(document).on('click', '.apply', function () {
        event.preventDefault();
        var this_btn = $(this);
        var package_id = $(this).attr('data-id');
        $.ajax({
            url: "/wallet/package/apply/"+package_id,
            method: "GET",
            
            beforeSend: function() {
                this_btn.html('Appling....');
            },
            success: function (data) {

                this_btn.html('Applyed');
                this_btn.attr('disabled', '');
                //console.log(data);

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