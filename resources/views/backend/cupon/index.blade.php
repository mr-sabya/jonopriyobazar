@extends('layouts.back')

@section('title', 'Cupon')

@section('button')
<button class="btn btn-success btn-icon float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"></i></button>
@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Cupon</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="cupon_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Code</th>
                                    <th>Amount</th>
                                    <th>Expire On</th>
                                    <th>Limit</th>
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

<!-- add/edit modal -->
<div class="modal fade" id="cupon_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="cupon_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="cupon_modal_title">Add Cupon</h4>
            </div>
            <form id="cupon_form" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Code</label>
                        <input type="text" class="form-control" id="code" name="code">
                        <span style="color: red" id="code_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount">
                        <span style="color: red" id="amount_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Expire On</label>
                        <input type="date" class="form-control" id="expire_date" name="expire_date">
                        <span style="color: red" id="expire_date_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Limit</label>
                        <input type="text" class="form-control" id="limit" name="limit" value="0">
                        <span style="color: red" id="limit_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>
                    
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


    $('#cupon_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.cupon.index') }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'code',
            name: 'code'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'expire_on',
            name: 'expire_on'
        },
        {
            data: 'limit',
            name: 'limit'
        },

        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    $('#code').keyup(function(event) {
        if($(this).val() != ''){
            $('#code_error').html('');
        }
    });

    $('#amount').keyup(function(event) {
        if($(this).val() != ''){
            $('#amount_error').html('');
        }
    });

    $('#limit').keyup(function(event) {
        if($(this).val() != ''){
            $('#limit_error').html('');
        }
    });

    $('#expire_date').change(function(event) {
        if($(this).val() != ''){
            $('#expire_date_error').html('');
        }
    });

    function resetError() {
        $('#code_error').html('');
        $('#amount_error').html('');
        $('#expire_date_error').html('');
        $('#limit_error').html('');
    }

    $('#add_new').click(function() {
        $('#cupon_form')[0].reset();
        
        $('#cupon_modal_title').text("Add New Cupon");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#cupon_modal').modal('show');
    });

    $('#cupon_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            $.ajax({
                url: "{{ route('admin.cupon.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#cupon_modal_loader').show();
                },
                success: function (data) {
                    $('#cupon_modal_loader').hide();
                    if (data.errors) {
                        $('#code_error').html(data.errors.code);
                        $('#amount_error').html(data.errors.amount);
                        $('#expire_date_error').html(data.errors.expire_date);
                        $('#limit_error').html(data.errors.limit);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#cupon_modal').modal('hide');
                            $('#cupon_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }

        
        // -------------> for update <-------------------------------- 
        if ($('#action').val() == 'Edit') {
            $.ajax({
                url: "{{ route('admin.cupon.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#cupon_modal_loader').show();
                },
                success: function (data) {
                    $('#cupon_modal_loader').hide();
                    if (data.errors) {
                        $('#code_error').html(data.errors.code);
                        $('#amount_error').html(data.errors.amount);
                        $('#expire_date_error').html(data.errors.expire_date);
                        $('#limit_error').html(data.errors.limit);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#cupon_modal').modal('hide');
                            $('#cupon_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }
    });

    // --------------------->for edit < -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
    
    $(document).on('click', '.edit', function () {
        $('#cupon_form')[0].reset();
        resetError();
        var id = $(this).attr('id');
        $('#cupon_modal').modal('show');
        // alert(id);
        $.ajax({
            url: "/control/cupon/" + id + "/edit",
            dataType: "json",
            beforeSend: function(){
                $('#cupon_modal_loader').show();
            },
            success: function (data) {
                $('#code').val(data.cupon.code);
                $('#amount').val(data.cupon.amount);
                $('#limit').val(data.cupon.limit);
                $('#expire_date').val(data.cupon.expire_date);
                $('#hidden_id').val(data.cupon.id);
                $('#action_button').html("Update");
                $('#cupon_modal_title').html('Edit Cupon')
                $('#action').val("Edit");
                $('#cupon_modal_loader').hide();
            }
        })
    });


    //========================>for delete =========================
    var district_id;

    $(document).on('click', '.delete', function () {
        district_id = $(this).attr('id');
        $('#confirmModal').modal('show');

        $('#ok_button').click(function () {
            $.ajax({
                url: "/control/district/delete/" + district_id,
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
                            $('#district_form')[0].reset();
                            $('#district_table').DataTable().ajax.reload();
                        });
                    }else if(data.error){
                        swal({
                            title: "Error!",
                            text: data.error,
                            icon: "warning",
                            button: "Ok!",
                        }).then((success) => {
                            $('#district_form')[0].reset();
                            $('#district_table').DataTable().ajax.reload();
                        });
                    }
                    
                }
            })
        });
    });

</script>


@endsection