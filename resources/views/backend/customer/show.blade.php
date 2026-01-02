@extends('layouts.back')

@section('title', 'Customer')

@section('content')

<div class="container-fluid customer">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="avatar">
                                    @if($user->image == null)
                                    <img src="{{ url('frontend/images/profile.png') }}" alt="{{ $user->name }}">
                                    @else
                                    <img src="{{ url('upload/profile_pic', $user->image)}}" alt="{{ $user->name }}">
                                    @endif
                                    @if($user->is_varified == 1)
                                    <span class="verify-status active"><i class="zmdi zmdi-check-circle"></i></span>
                                    @else
                                    <span class="verify-status deactive"><i class="zmdi zmdi-close-circle"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="name">
                                <h3>{{ $user->name}}</h3>
                                <p>{{ $user->phone }}</p>
                                <div class="status">
                                    @if($user->status == 1)
                                    <span class="badge badge-success">Active</span>
                                    @elseif($customer->status == 2)
                                    <span class="badge badge-warning">Hold</span>
                                    @else
                                    <span class="badge badge-danger">Deactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">Credit Wallet Balance <br><strong><span id="wallet_balance">{{ $user->wallet_balance }}</span></strong> ৳</h4>
                            <a href="{{ route('admin.walletuser.show', $user->id) }}" class="btn btn-primary">Credit Wallet</a>
                        </div>
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">Refer Balance <br><strong><span id="total_purchase">{{ $user->ref_balance }}</span></strong> ৳</h4>
                            <a href="{{ route('admin.referhistory.index', $user->id)}}" class="btn btn-primary">Refer Balance List</a>
                        </div>
                        <div class="col-4">
                            <h4 class="p-0 m-0">Total Point <br><strong><span id="total_due">{{ $user->point }}</span></strong></h4>
                            <a href="{{ route('admin.pointhistory.index', $user->id)}}" class="btn btn-primary">Point Table</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Product Order <br><strong><span id="wallet_balance">{{ $orders->where('type', 'product')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Custom Order <br><strong><span id="total_purchase">{{ $orders->where('type', 'custom')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Medicine Order <br><strong><span id="total_purchase">{{ $orders->where('type', 'medicine')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3">
                            <h4 class="p-0 m-0">Electricity Bill <br><strong><span id="total_due">{{ $orders->where('type', 'electricity')->sum('grand_total') }}</span></strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">On Cash <br><strong><span id="wallet_balance">{{ $orders->where('payment_option', 'cash')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">On Credit <br><strong><span id="total_purchase">{{ $orders->where('payment_option', 'wallet')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-4">
                            <h4 class="p-0 m-0">Refer Balance <br><strong><span id="total_purchase">{{ $orders->where('payment_option', 'refer')->sum('grand_total') }}</span></strong> ৳</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Address</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="address_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Default Shipping</th>
                                    <th>Default Billing</th>
                                </tr>
                            </thead>
                            <tbody>

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

                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Refer</strong> List ({{ $refer_count }})</h2>

                    @if($user->is_percentage == 0)
                    <a class="btn btn-success" href="{{ route('admin.referpercentage.status', $user->id)}}">Active Refer Percentage</a>
                    @else
                    <a class="btn btn-danger" href="{{ route('admin.referpercentage.status', $user->id)}}">Deactive Refer Percentage</a>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="refer_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Verify Status</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="order_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Time + Area</th>
                                    <th>Invoice No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Order Type</th>
                                    <th>Status</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- for modal showing delete --}}
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')


@include('backend.partials.datatable.js')

<script>

    var user_id = "{{ $user->id }}";

    $('#refer_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/control/customer/refer/"+user_id,
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'verify_status',
            name: 'verify_status'
        },
        {
            data: 'customer_status',
            name: 'customer_status'
        },
        {
            data: 'orders',
            name: 'orders'
        }


        ]
    });

    $('#address_table').DataTable();


    $('#order_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/control/fetch-order/{{ $user->id}}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'time',
            name: 'time'
        },
        {
            data: 'invoice',
            name: 'invoice'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'grand_total',
            name: 'grand_total'
        },
        {
            data: 'payment_method',
            name: 'payment_method'
        },
        {
            data: 'type',
            name: 'type'
        },
        {
            data: 'order_status',
            name: 'order_status'
        },

        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });


</script>


@endsection