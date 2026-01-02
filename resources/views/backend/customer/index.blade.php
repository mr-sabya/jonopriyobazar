@extends('layouts.back')

@section('title', 'Customer')

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">



        <div class="col-md-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Cusomer</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="customer_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Verify Status</th>
                                    <th>Status</th>
                                    <th>Refers</th>
                                    <th>Credit Balance</th>
                                    <th>Refer Balance</th>
                                    <th>Point</th>
                                    <th>Created At</th>
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
    // ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#customer_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.customer.index') }}",
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
            data: 'refers',
            name: 'refers'
        },
        {
            data: 'wallet_balance',
            name: 'wallet_balance'
        },
        {
            data: 'ref_balance',
            name: 'ref_balance'
        },
        {
            data: 'point',
            name: 'point'
        },

        {
            data: 'create_time',
            name: 'create_time'
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