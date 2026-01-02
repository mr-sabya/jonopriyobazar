@extends('layouts.back')

@section('title', 'Custom Order List')


@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

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



<!-- delete modal -->
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




    $('#order_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.customorder.index') }}",
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