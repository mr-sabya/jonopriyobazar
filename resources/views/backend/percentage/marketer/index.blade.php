@extends('layouts.back')

@section('title', 'Marketer')

@section('button')
<button class="btn btn-success btn-icon float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"></i></button>
@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">Total Earning <br><strong><span id="percentage_balance">{{ number_format((float)$percentage->sum('amount'), 2, '.', '') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-4 border-right">
                            <h4 class="p-0 m-0">Total Withdraw <br><strong><span id="withdraw_balance">{{ number_format((float)$withdraw->sum('amount'), 2, '.', '') }}</span></strong> ৳</h4>
                        </div>
                        <div class="col-4">
                            <h4 class="p-0 m-0">Balance <br><strong><span id="due_balance">{{ number_format((float)$percentage->sum('amount') - $withdraw->sum('amount'), 2, '.', '') }}</span></strong> ৳</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Percentage</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="percentage_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Date</th>
                                    <th>Order</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <button id="add_payment" class="btn btn-success"><i class="zmdi zmdi-plus"></i> Add Payment</button>
            <div class="card">
                <div class="header">
                    <h2><strong>Withdraw</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="withdraw_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- add/edit modal -->
<div class="modal fade" id="withdraw_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="withdraw_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="withdraw_modal_title">Add Withdraw</h4>
            </div>
            <form id="withdraw_form" method="post" action="{{ route('admin.marketerwithdraw.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                        <span style="color: red" id="date_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount">
                        <span style="color: red" id="amount_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="method">Method</label>
                        <input type="text" class="form-control" id="method" name="method">
                        <span style="color: red" id="method_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">Save</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
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


    $('#percentage_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.marketer.fetch') }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'order_date',
            name: 'order_date'
        },
        {
            data: 'order_invoice',
            name: 'order_invoice'
        },
        {
            data: 'amount',
            name: 'amount',
        },
        ]
    });


    $('#withdraw_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.marketerwithdraw.fetch') }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'withdraw_date',
            name: 'withdraw_date'
        },
        {
            data: 'method',
            name: 'method'
        },
        {
            data: 'amount',
            name: 'amount',
        }
        ]
    });


    $('#add_payment').click(function() {
        $('#withdraw_form')[0].reset();
        $('#date_error').html('');
        $('#amount_error').html('');
        $('#method_error').html('');
        
        $('#withdraw_modal').modal('show');
    });

    $('#withdraw_form').on('submit', function (event) {
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
                $('#withdraw_modal_loader').show();
            },
            success: function (data) {
                $('#withdraw_modal_loader').hide();
                if (data.errors) {
                    $('#date_error').html(data.errors.date);
                    $('#amount_error').html(data.errors.amount);
                    $('#method_error').html(data.errors.method);
                }
                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {
                        $('#withdraw_modal').modal('hide');
                        $('#withdraw_table').DataTable().ajax.reload();

                        $('#percentage_balance').html(data.percentage);
                        $('#withdraw_balance').html(data.withdraw);
                        $('#due_balance').html(data.balance);
                    });

                }

            }
        })
        
    });

    


    //========================>for delete =========================
    var withdraw_id;

    $(document).on('click', '.delete', function () {
        withdraw_id = $(this).attr('id');
        $('#confirmModal').modal('show');

        $('#ok_button').click(function () {
            $.ajax({
                url: "/control/marketer/withdraw/" + withdraw_id,
                method: "DELETE",
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('Ok');
                    if(data.success){
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#withdraw_form')[0].reset();
                            $('#withdraw_table').DataTable().ajax.reload();
                            $('#percentage_balance').html(data.percentage);
                            $('#withdraw_balance').html(data.withdraw);
                            $('#due_balance').html(data.balance);
                        });
                    }
                    
                }
            })
        });
    });

</script>


@endsection