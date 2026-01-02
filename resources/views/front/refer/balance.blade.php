@extends('layouts.front')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/dropify/css/dropify.min.css') }}">
@endsection

@section('title', 'Refer History')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('user.wallet')}}"><i class="fas fa-arrow-left"></i> Go Back</a>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body text-center">
                            <h3>Refer Wallet</h3>
                            <h6>Balance: {{ Auth::user()->ref_balance }}৳</h6>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#balance">Balance History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#purchasse">Purchase History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#withdraw">Withdraw History</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div id="balance" class="container tab-pane active"><br>
                            <h3>Wallet Purchase History</h3>
                            <div class="table-responsive">
                                <table class="table" id="balanace_table">
                                    <thead>
                                        <tr>
                                            <th>Date#</th>
                                            <th>Order</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($balances as $balance)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($balance->date))}}</td>
                                            <td><a href="">#{{ $balance->order['invoice']}}</a></td>
                                            <td class="text-right">{{ $balance->amount }}৳</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="purchasse" class="container tab-pane fade"><br>
                            <h3>Purchase History</h3>
                            <div class="table-responsive">
                                <table class="table" id="purchase_table">
                                    <thead>
                                        <tr>
                                            <th>Date#</th>
                                            <th>Order</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($purchases as $purchase)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($purchase->date))}}</td>
                                            <td><a href="">#{{ $purchase->order['invoice']}}</a></td>
                                            <td class="text-right">{{ $purchase->amount }}৳</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="withdraw" class="container tab-pane fade"><br>
                            <h3>Withdraw</h3>
                            <div class="text-right mb-3">
                                <button id="request_button" class="btn btn-primary"><i class="fas fa-plus"></i> Request Withdraw</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table w-100" id="withdraw_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th class="text-right">Amount</th>
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
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->


<div class="modal" id="request_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdraw Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('login')}}" id="withdraw_form" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="number" class="form-control" name="amount" id="amount">
                        <small style="color: red" id="amount_error"></small>
                    </div>
                    
                    
                    <div class="form-group">
                        <button type="submit" id="action_btn" class="btn btn-fill-out btn-block">Request</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('frontend/dropify/js/dropify.min.js') }}"></script>
@include('backend.partials.datatable.js')
<script>

    $('#balanace_table').DataTable();
    $('#purchase_table').DataTable();
    

    $('#withdraw_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('user.withdraw.index') }}",
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
            name: 'date',
        },
        {
            data: 'request_amount',
            name: 'request_amount',
            className: "text-right"
        },
        {
            data: 'data_status',
            name: 'data_status'
        },

        
        ]
    });

    $('#request_button').click(function(event) {
        $('#request_modal').modal('show');
    });

    $('#withdraw_form').on('submit', function (event) {
        event.preventDefault();
        
        $.ajax({
            url: "{{ route('user.withdraw.store') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function(){
                $('#action_btn').html('Requesting...');
            },
            success: function (data) {
                $('#action_btn').html('Request');
                if (data.errors) {
                    $('#amount_error').html(data.errors.amount);
                }
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((success) => {
                        $('#request_modal').modal('hide');
                        $('#withdraw_table').DataTable().ajax.reload();
                    });

                }

            }
        })
        
        
    });

</script>

@endsection