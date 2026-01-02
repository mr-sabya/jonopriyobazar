@extends('layouts.front')

@section('title')
Order#{{ $order->invoice }}
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">


            <div class="row justify-content-center">

                <div class="col-md-8">
                    <div class="order_review">

                        <div class="heading_s1 m-0">
                            <div class="order-info">
                                <h6>Order: #{{ $order->invoice }}</h6>
                                <p class="m-0">Placed On: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <form id="cancel_form" action="{{ route('profile.order.cencel.submit')}}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="form-group">
                                    <label>Cancel Reason</label>
                                    <select class="form-control" id="reason_id" name="reason_id">
                                        <option value="" disabled selected>(Select Reason)</option>
                                        @foreach($reasons as $reason)
                                        <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="reason_id_error" style="color: red"></small>
                                </div>

                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="remark" id="remark"></textarea>
                                </div>

                                <div class="border p-3 mb-3">
                                    <h6>Cancelation Terms</h6>
                                    <ul style="list-style: none;">
                                        <li>১. অর্ডার ক্যানসেল করলে আপনার অর্জিত পয়েন্ট বাতিল হবে</li>
                                        <li>২. আপনি যদি ক্রেডিট ওয়ালেট ব্যবহার করেন তাহলে বিল পুরনায় ক্রেডিট ওয়ালেটে যুক্ত হবে</li>
                                        <li>৩. উপযুক্ত কারণ ছাড়া আপনি অর্ডার ক্যানসেল করতে পারবেন না</li>
                                    </ul>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_agree" name="is_agree_cancel" value="1">
                                    <label class="form-check-label" for="is_agree">Agree with Cancelation Terms</label><br>
                                    <small id="is_agree_error" style="color: red"></small>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Cancel Order</button>
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
<script>

    $('#reason_id').change(function(event) {
        if($(this).val() != ''){
            $('#reason_id_error').html('');
        }
    });

    $('#is_agree').click(function(event) {
        if($(this).val() != ''){
            $('#is_agree_error').html('');
        }
    });

    $('#cancel_form').on('submit', function (event) {
        event.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            
            success: function (data) {

                if (data.errors) {
                    $('#reason_id_error').html(data.errors.reason_id);
                    $('#is_agree_error').html(data.errors.is_agree_cancel);
                    
                }

                if(data.route){
                    window.location = data.route;
                }
                

            }
        })
        
    });


</script>
@endsection