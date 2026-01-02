@extends('layouts.back')

@section('title', 'Credit Wallet User')

@section('content')

<div class="container-fluid customer">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Balance <br><strong><span id="wallet_balance">{{ $user->wallet_balance }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Total Purchase <br><strong><span id="total_purchase">{{ $user->walletPurchase->sum('amount') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3 border-right">
                            <h4 class="p-0 m-0">Total Pay <br><strong><span id="total_pay">{{ $user->walletPay->sum('amount') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-3">
                            <h4 class="p-0 m-0">Due <br><strong><span id="total_due">{{ $user->walletPurchase->sum('amount')-$user->walletPay->sum('amount') }}</span></strong> ৳</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="body">
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
                            @elseif($user->status == 2)
                            <span class="badge badge-warning">Hold</span>
                            @else
                            <span class="badge badge-danger">Deactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="wallet_status text-center">
                        Wallet Sttatus : 
                        @if($user->is_wallet == 1)
                        @if($user->is_hold == 1)
                        <span class="badge badge-warning">Hold</span>
                        @else
                        <span class="badge badge-success">Active</span>
                        @endif
                        @elseif($user->is_wallet == 0)
                        <span class="badge badge-warning">Deactive</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="body">
                    <div class="container">
                        <h3>Wallet Info</h3>

                        <p class="m-0">National ID</p>
                        <div class="row">
                            @if($user->n_id_front != null)
                            <div class="col-6">
                                <img src="{{ url('upload/images', $user->n_id_front)}}" class="w-100">
                            </div>
                            <div class="col-6">
                                <img src="{{ url('upload/images', $user->n_id_back)}}" class="w-100">
                            </div>
                            @endif
                        </div>
                        @if($user->is_hold == 0)
                        <a href="{{ route('admin.wallet.hold', $user->id)}}" id="wallet_hold" class="btn btn-warning mt-3">Hold</a>
                        @elseif($user->is_hold == 1)
                        <a href="{{ route('admin.wallet.reactive', $user->id)}}" id="wallet_hold" class="btn btn-success mt-3">Re-Active</a>
                        @endif

                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                @if($user->walletPurchase->sum('amount')-$user->walletPay->sum('amount') == 0)
                <button id="apply_package" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Change Package</button>
                @endif
                <div class="body">
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package</th>
                                    <th>Apply At</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($packages)>0)
                                @foreach($packages as $package)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $package->package->amount }} - {{ $package->package->validate }} Days</td>
                                    <td> {{ date('d-m-Y', strtotime($package->created_at)) }}</td>

                                    <td> 
                                        @if($package->valid_from != null)
                                        {{ date('d-m-Y h:i A', strtotime($package->valid_from)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->valid_to != null)
                                        {{ date('d-m-Y h:i A', strtotime($package->valid_to)) }}
                                        <br>
                                        @if(\Carbon\Carbon::now()>$package->valid_to)
                                        <span style="color: red">Expired</span>
                                        @endif
                                        @endif
                                    </td>

                                    <td> 
                                        @if($package->status == 1)
                                        <span style="font-weight: bold; background: #43A047; color: #fff; padding: 10px 20px; border-radius: 8px">Currently Active</span>
                                        @endif
                                    </td>
                                    <td>

                                        @if($package->status == 0)
                                        <a href="{{ route('admin.packageapplication.approve', $package->id)}}" type="button" id="{!! $package->id !!}" class="btn btn-table waves-effect waves-float btn-sm waves-green">Approve</a>

                                        <a href="javascript:void(0)" data-url="{{ route('admin.packageapplication.delete', $package->id)}}" type="button" class="delete btn btn-table waves-effect waves-float btn-sm waves-red">Delete</a>
                                        @else
                                        @if($user->is_expired == 1)
                                        <a href="javascript:void(0)" type="button" data-id="{!! $package->id !!}" data-value="{{ $package->valid_to }}" class="extend btn btn-table waves-effect waves-float btn-sm waves-green">Extened</a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7">No Package Assigned</td>
                                </tr>
                                @endif
                            </tbody>
                            

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Credit Purchase</h4>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table id="purchase_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Order</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <button id="pay_btn" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Payment</button>
                <div class="card-header">
                    <h4 class="m-0">Credit Pay</h4>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table id="pay_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- change package -->
<div class="modal fade" id="package_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="package_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="package_modal_title">Add Package</h4>
            </div>
            <form id="package_form" method="post" action="{{ route('admin.walletpackage.change')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{$user->id }}">
                    <div class="form-group">
                        <label for="name">Credit Wallet Package</label>
                        <select class="form-control" name="package_id" id="package_id" required>
                            <option value="" selected disabled>(Select Package)</option>
                            @foreach($packs as $pack)
                            <option value="{{ $pack->id }}">{{ $pack->amount }} - {{ $pack->validate }} Days</option>
                            @endforeach
                        </select>
                        <span style="color: red" id="name_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>
                    
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- extend package -->
<div class="modal fade" id="extend_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="extend_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="extend_modal_title">Extend Package</h4>
            </div>
            <form id="extend_form" method="post" action="{{ route('admin.walletpackage.extend')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="package_id" id="user_package_id" >
                    <div class="form-group">
                        <label for="name">Valid To</label>
                        <input type="datetime-local" name="valid_to" id="valid_to" class="form-control" required>
                        <span style="color: red" id="valid_to_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>
                    
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- extend package -->
<div class="modal fade" id="pay_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="pay_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="pay_modal_title">Add Payment</h4>
            </div>
            <form id="pay_form" method="post" action="{{ route('admin.payment.store')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="date">Valid To</label>
                        <input type="date" name="date" id="date" class="form-control">
                        <span style="color: red" id="date_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control">
                        <span style="color: red" id="amount_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>
                    
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- delete modal -->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <form id="delete_form" action="" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@section('scripts')


@include('backend.partials.datatable.js')

<script>
    // ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#wallet_approve', function () {
        $.ajax({
            url: $(this).attr('data-url'),
            success: function (data) {
                if(data.success){
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {
                        location.reload();
                    });
                }else if(data.error){
                    swal({
                        title: "Error!",
                        text: data.error,
                        icon: "warning",
                        button: "Ok!",
                    });
                }
            }
        })
    });


    $(document).on('click', '.delete', function () {
        $('#confirmModal').modal('show');
        $('#delete_form').attr('action', $(this).attr('data-url'));
    });

    $('#apply_package').click(function(event) {
        $('#package_modal').modal('show');
    });

    $(document).on('click', '.extend', function () {
        $('#extend_modal').modal('show');
        var package_id = $(this).attr('data-id');
        var data_value = $(this).attr('data-value')
        $('#user_package_id').val(package_id);
        $('#valid_to').val(data_value);
    });


    $('#purchase_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/control/user/purchase/history/{{ $user->id }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'date',
            name: 'date'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });


    $('#pay_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/control/user/pay/history/{{ $user->id }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'date',
            name: 'date'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    $("#pay_btn").click(function(event) {
        $('#pay_modal').modal('show');
    });

    $('#pay_form').on('submit', function (event) {
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
                $('#pay_modal_loader').show();
            },
            success: function (data) {
                $('#pay_modal_loader').hide();
                if (data.errors) {
                    $('#date_error').html(data.errors.date);
                    $('#amount_error').html(data.errors.amount);
                }
                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {
                        $('#pay_modal').modal('hide');
                        $('#pay_table').DataTable().ajax.reload();
                        $('#wallet_balance').html(data.wallet_balance);
                        $('#total_purchase').html(data.total_purchase);
                        $('#total_pay').html(data.total_pay);
                        $('#total_due').html(data.total_due);
                    });

                }

            }
        })
    });

</script>


@endsection