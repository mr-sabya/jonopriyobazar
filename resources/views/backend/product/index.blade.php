
@extends('layouts.back')

@section('title', 'Products')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Product</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="category_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="10%">Image</th>
                                    <th style="text-align: left;" width="40%">Name</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Sale Price</th>
                                    <th width="10%">Actual Price</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Sale Price</th>
                                    <th>Actual Price</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="confirm_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif') }}">
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('backend.partials.datatable.js')


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#category_table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: "{{ route('admin.products.index') }}",
        },
        columns:[
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'productimage',
            name: 'productimage'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'categories',
            name: 'categories'
        },
        {
            data: 'sale_price',
            name: 'sale_price'
        },
        {
            data: 'actual_price',
            name: 'actual_price'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    var product_id;

    $(document).on('click', '.delete', function() {
        product_id = $(this).attr('data-id');
        $('#confirm_modal').modal('show');
    });

    $('#ok_button').click(function(event) {
        $('#delete_'+product_id).submit();
    });

</script>

@endsection
