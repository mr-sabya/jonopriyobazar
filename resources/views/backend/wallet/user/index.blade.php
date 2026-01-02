@extends('layouts.back')

@section('title', 'Credit Wallet User')


@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-12">
            <div class="card">

                <div class="header">
                    <h2><strong>User</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="user_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Active Packge</th>
                                    <th>Expire On</th>
                                    <th>Total Purchase</th>
                                    <th>Total Pay</th>
                                    <th>Total Due</th>
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


    $('#user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.walletuser.index') }}",
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
            data: 'active_package',
            name: 'active_package'
        },
        {
            data: 'expire_on',
            name: 'expire_on'
        },
        {
            data: 'total_purchase',
            name: 'total_purchase'
        },
        {
            data: 'total_pay',
            name: 'total_pay'
        },
        {
            data: 'total_due',
            name: 'total_due'
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