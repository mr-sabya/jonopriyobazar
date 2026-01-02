@extends('layouts.back')

@section('title')
Custom Order#{{ $order->invoice }}
@endsection

@section('button')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>User</strong> Info </h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-6 border-right">
                            <h4 class="text-center">Credit Wallet Balance
                                <br>
                                {{ $order->customer['wallet_balance']}} ৳
                            </h4>
                        </div>
                        <div class="col-6">
                            <h4 class="text-center">Refer Wallet Balance
                                <br>
                                {{ $order->customer['ref_balance']}} ৳
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <div class="order-info">
                        <h3>Custom Order: #{{ $order->invoice }}</h3>
                        <h3><strong>{{ $order->customer['name']}}</strong></h3>
                        <p>Date: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Shipping Address</h4>
                            <p><strong>{{ $order->shippingAddress['name'] }}</strong><br>
                                {{ $order->shippingAddress['street'] }},<br> {{ $order->shippingAddress['city']['name'] }} - {{ $order->shippingAddress['post_code']}}, {{ $order->shippingAddress['thana']['name'] }}, {{ $order->shippingAddress['district']['name']}}<br>
                                {{ $order->shippingAddress['phone']}}<br>
                                <span class="badge badge-warning">
                                    @if($order->shippingAddress['type'] == 'home') Home @else Office @endif
                                </span>
                            </p>

                        </div>

                        <div class="col-md-6">
                            <h4>Billing Address</h4>
                            <p><strong>{{ $order->billingAddress['name'] }}</strong><br>
                                {{ $order->billingAddress['street'] }},<br> {{ $order->billingAddress['city']['name'] }} - {{ $order->billingAddress['post_code']}}, {{ $order->billingAddress['thana']['name'] }}, {{ $order->billingAddress['district']['name']}}<br>
                                {{ $order->billingAddress['phone']}}<br>
                                <span class="badge badge-warning">
                                    @if($order->billingAddress['type'] == 'home') Home @else Office @endif
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="m-0 p-0">List</h3>
                            @if($order->custom != '' )
                            <div class="list border p-3">
                                {!! $order->custom !!}
                            </div>
                            @endif

                            @if($order->image !=  '')
                            <div class="list border p-3">
                                <img src="{{ url('upload/images', $order->image) }}" style="width: 100%">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6">
                    <div class="card">


                        <div class="body">
                            <form id="update_form" action="{{ route('admin.customorder.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" name="total" id="total" class="form-control" value="{{ $order->total }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Delivery Charge</label>
                                            <input type="text" name="deliver_charge" id="deliver_charge" class="form-control" value="{{ $order->shippingAddress['city']['delivery_charge'] }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Grand Total</label>
                                            <input type="text" name="grand_total" id="grand_total" class="form-control" value="{{ $order->grand_total }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">


                        <div class="body">
                            <form id="payment_form" action="{{ route('admin.customorder.updatepayment')}}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="form-group">
                                    <label>Chanage Payment Method</label>
                                    <select class="form-control" name="payment_option" id="payment_option">
                                        <option value="" selected disabled="">(Select payment method)</option>
                                        <option value="cash" {{ $order->payment_option == 'cash' ? 'selected' : '' }}>Cash On Delivery</option>
                                        <option value="wallet" {{ $order->payment_option == 'wallet' ? 'selected' : '' }}>Credit Wallet</option>
                                        <option value="refer" {{ $order->payment_option == 'refer' ? 'selected' : '' }}>Refer Wallet</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> Status </h2>
                </div>
                

                <div class="body">

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="text-center">
                                @foreach($statuses as $status)

                                @if($status->slug == 'canceled')
                                <hr>
                                <p>To Cancel Order</p>
                                @endif
                                <button class="history btn {{ $order->isActiveHistory($status->id) ? 'btn-success' : 'btn-primary' }} p-3 w-100" data-id="{{ $status->id }}">{{ $status->name }}</button><br>
                                @if(!$loop->last)
                                <i class="zmdi zmdi-long-arrow-down"></i>
                                <br>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> History </h2>
                </div>
                <div class="body">
                    <div class="order-info">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover w-100" id="history_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date-Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>




<div class="modal fade" id="history_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="history_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="history_modal_title">Add Hsitory</h4>
            </div>
            <form id="history_form" method="post">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="form-group">
                        <label for="date_time">Date Time</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time">
                        <span style="color: red" id="date_time_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="date_time">Status</label>
                        <select class="form-control" name="status_id" id="status_id">

                        </select>
                        <span style="color: red" id="status_id_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>

                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection


@section('scripts')


@include('backend.partials.datatable.js')

<script>

    $('#history_table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        ajax: {
            url: "/control/order/history/{{ $order->id }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'date_time',
            name: 'date_time'
        },
        {
            data: 'status',
            name: 'status'
        }
        ]
    });


    $(document).on('click', '.history', function () {
        var data_id = $(this).attr('data-id');
        var order_id = '{{ $order->id }}';
        var this_btn = $(this);

        $.ajax({
            url: "{{ route('admin.orderhistory.store') }}",
            method: "POST",
            data: {
                'order_id': order_id,
                'status_id': data_id,
            },
            dataType: "json",
            
            success: function (data) {
                console.log(data);
                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {

                        this_btn.removeClass('btn-primary');
                        this_btn.addClass('btn-success');
                        $('#history_modal').modal('hide');
                        $('#history_table').DataTable().ajax.reload();
                    });
                }

            }
        })
    });

    $('#total').keyup(function(event) {
        var total = $(this).val();
        var charge = $('#deliver_charge').val();

        var grand_total = parseInt(total) + parseInt(charge);
        $('#grand_total').val(parseInt(grand_total));
    });

    $(document).on('submit','#update_form',function(e){
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

                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    })
                }

                if (data.error) {
                    swal({
                        title: "Error!",
                        text: data.error,
                        icon: "warning",
                        button: "Ok!",
                    })
                }
            }
        })
    });

    $(document).on('submit','#payment_form',function(e){
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

                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    })
                }
            }
        })
    });


</script>


@endsection