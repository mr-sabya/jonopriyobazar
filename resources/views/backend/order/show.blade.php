@extends('layouts.back')

@section('title', 'Order List')

@section('button')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <a href="{{ route('admin.order.download', $order->id)}}" class="btn btn-success float-right"><i class="zmdi zmdi-download"></i> Download</a>
            <div class="card">
                <div class="body">
                    <div class="order-info">
                        <h3>Order: #{{ $order->invoice }}</h3>
                        <h3><strong>{{ $order->customer['name']}}</strong></h3>
                        <p class="m-0">Date: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                        <p>Payment By:
                            @if($order->payment_option == 'cash')
                            Cash On Delievery
                            @elseif($order->payment_option == 'wallet')
                            Credit Wallet
                            @elseif ($order->payment_option == 'refer')
                            Refer Wallet
                        @endif</p>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover product-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="text-right">Price</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td><img src="{{ url('upload/images', $item->product['image'])}}" style="width: 100px"></td>
                                            <td>{{ $item->product['name'] }} - {{ $item->product['quantity']}}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="text-right">
                                                @if($order->payment_option =='wallet')
                                                {{ $item->product['actual_price'] }}
                                                @else
                                                {{ $item->product['sale_price'] }}
                                                @endif

                                            </td>
                                            <td class="text-right">{{ $item->price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Sub Total</th>
                                            <th>
                                                {{ $order->sub_total }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Cupon</th>
                                            <th>
                                                @if($order->cupon_id != null)
                                                - {{ $order->cupon['amount']}}
                                                @else
                                                No Cupon
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th>
                                                {{ $order->total }}
                                            </th>
                                        </tr>

                                        <tr>
                                            <th colspan="5">Delivery Charge</th>
                                            <th>
                                                + {{ $order->shippingAddress['city']['delivery_charge'] }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Grand Total</th>
                                            <th>
                                                {{ $order->grand_total }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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


</script>


@endsection