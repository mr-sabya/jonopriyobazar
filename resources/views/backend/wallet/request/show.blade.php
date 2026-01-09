@extends('layouts.back')

@section('title', 'Customer')

@section('content')

<div class="container-fluid customer">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="body">
                            <div class="text-center">
                                <div class="avatar">
                                    @if($user->image == null)
                                    <img src="{{ Avatar::create('John Doe')->toBase64() }}" alt="{{ $user->name }}">
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

                <div class="col-md-8">
                    <div class="card">
                        <div class="body">
                            <div id="wallet" class="container">
                                <p>National ID</p>
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ url('upload/images', $user->n_id_front)}}" class="w-100">
                                    </div>
                                    <div class="col-6">
                                        <img src="{{ url('upload/images', $user->n_id_back)}}" class="w-100">
                                    </div>
                                </div>
                                @if($user->is_wallet == 0)
                                <a href="javascript:void(0)" data-url="{{ route('admin.wallet.approve', $user->id)}}" id="wallet_approve" class="btn btn-success mt-3">Approve</a>
                                @endif
                                
                            </div>

                        </div>
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

    $(document).on('click', '#wallet_hold', function () {
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


</script>


@endsection