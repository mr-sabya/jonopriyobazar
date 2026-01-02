@extends('layouts.front')

@section('title')
Electricity Bill
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="custom-container">
            <div class="row">
                <div class="col-12">

                    <div class="row justify-content-center" id="company">
                        @if($companies->count()>0)
                        @foreach($companies as $company)
                        <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                            <a href="javascript:void(0)" class="{{ Auth::user() ? 'bill' : 'modal-login' }}" data-id="{{ $company->id }}">
                                <div class="product_wrap text-center">
                                    <div class="category_image">
                                        @if($company->logo == null)
                                        <img src="{{ url('frontend/images/demo.png')}}" alt="demo">
                                        @else
                                        <img src="{{ url('upload/images', $company->logo) }}" alt="el_img2">
                                        @endif
                                    </div>
                                    <div class="category_info mt-2">
                                        <h6 class="product_title text-center m-0">
                                            {{ $company->name }}
                                        </h6>
                                        <p class="m-0" style="font-size: 12px">({{ $company->type }})</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-6">No Category Found</div>
                        @endif
                    </div>
                    @if(Auth::user())
                    <div class="row justify-content-center" id="form_div" style="display: none;">
                        <div class="col-lg-5 col-12">
                            <a href="javascript:void(0)" id="go_back"><i class="fas fa-arrow-left"></i> Go Back</a>
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('electricity.order')}}" method="post" id="electricity_form">
                                        @csrf
                                        <input type="hidden" name="company_id" id="company_id">
                                        <div class="form-group">
                                            <label>মিটার নম্বর/গ্রাহক নম্বর</label>
                                            <input type="text" name="meter_no" id="meter_no" class="form-control">
                                            <small style="color: red" id="meter_no_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <label>মোবাইল নম্বর</label>
                                            <input type="text" name="phone" id="phone" class="form-control">
                                            <small style="color: red" id="phone_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <label>টাকার পরিমাণ</label>
                                            <input type="text" name="amount" id="amount" class="form-control">
                                            <small style="color: red" id="amount_error"></small>
                                        </div>
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

                                        @if(Auth::user())
                                        <input type="hidden" name="user_wallet" id="user_wallet" value="{{ Auth::user()->wallet_balance }}">
                                        @endif

                                        <div class="form-group">
                                            <button class="btn btn-primary" id="submit_btn">Submit</button>
                                        </div>
                                    </form>


                                    <h4 style="margin-top: 20px">নিয়মাবলী:</h4>
                                    <ul style="list-style: none; line-height: 30px; font-size: 14px; color: #000">
                                        <li>১. মিটার রির্চাজ র্চাজ ১০ টাকা (১০০ টাকা থেকে ১,০০০ টাকা পর্যন্ত )</li>
                                        <li>২. মিটার রির্চাজ র্চাজ 20 টাকা (১,০০১ টাকা থেকে ২,০০০ টাকা পর্যন্ত )</li>
                                        <li>৩. মিটার রির্চাজ র্চাজ ৩০ টাকা (২,০০১ টাকা থেকে ৩,০০০ টাকা পর্যন্ত )</li>
                                        <li>৪. মিটার রির্চাজ র্চাজ ৪০ টাকা (৩,০০১ টাকা থেকে ৪,০০০ টাকা পর্যন্ত )</li>
                                        <li>৫. মিটার রির্চাজ র্চাজ ৫০ টাকা (৪,০০১ টাকা থেকে ১০,০০০ টাকা পর্যন্ত )</li>
                                        <li>৬. সকাল ৯.০০ থেকে রাত ৯.০০ পর্যন্ত মিটার রির্চাজ করা যাবে</li>
                                        <li>৭. টোকেন আসতে মাঝে মাঝে অনেক সময় লাগে ( বেশি ইমারজেন্সি টোকেন প্রয়োজন হলে অনুগ্রহ করে আমাদেরকে রির্চাজ করতে দিবেন না )</li>
                                        <li>৮. মিটার সংকান্ত যে কোন সমস্যা হইলে কল করুন এই নম্বরে +88 01322 882568 ( সকাল ৯.০০ থেকে রাত ৯.০০ পর্যন্ত)</li>

                                    </ul>
                                </div>
                            </div>
                        </div>
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

<script>
    $('.bill').click(function(event) {
        var company_id = $(this).attr('data-id');
        $('#company').hide();
        $('#company_id').val(company_id);
        $('#form_div').show();
    });

    $('#go_back').click(function(event) {
        $('#form_div').hide();
        $('#company_id').val('');
        $('#company').show();
    });

    $('#amount').keyup(function(event) {
        $('#wallet_radio').removeAttr('disabled');
        var amount = $(this).val();
        var balance = $('#user_wallet').val();


        if(parseInt(amount) > parseInt(balance)){
            $('#wallet_radio').attr('disabled', '');
        }
    });


    $('#electricity_form').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function(){
                $('#submit_btn').html('Sending...');
            },
            success: function (data) {
                $('#submit_btn').html('Submit');
                if (data.errors) {
                    $('#phone_error').html(data.errors.phone);
                    $('#meter_no_error').html(data.errors.meter_no);
                    $('#amount_error').html(data.errors.amount_error);
                }
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Electricity bill order has been send!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((success) => {
                        $('#form_div').hide();
                        $('#company_id').val('');
                        $('#company').show();
                    });;

                    

                }

            }
        })

    });
</script>
@endsection