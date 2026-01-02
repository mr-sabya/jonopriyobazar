@extends('layouts.back')

@section('title', 'Cancel Reason')

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
                    <h2><strong>Cancel Reason</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="reason_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>Cancel Reason</th>
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
<div class="modal fade" id="reason_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="reason_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="reason_modal_title">Add Cancel Reason</h4>
            </div>
            <form id="reason_form" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Calcel Reason</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span style="color: red" id="name_error"></span>
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


    $('#reason_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.reason.index') }}",
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
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    $('#name').keyup(function(event) {
        if($(this).val() != ''){
            $('#name_error').html('');
        }
    });

    $('#add_new').click(function() {
        $('#reason_form')[0].reset();
        $('#name_error').html('');
        $('#reason_modal_title').text("Add New Reason");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#reason_modal').modal('show');
    });

    $('#reason_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            $.ajax({
                url: "{{ route('admin.reason.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#reason_modal_loader').show();
                },
                success: function (data) {
                    $('#reason_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#reason_modal').modal('hide');
                            $('#reason_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }

        
        // -------------> for update <-------------------------------- 
        if ($('#action').val() == 'Edit') {
            $.ajax({
                url: "{{ route('admin.reason.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#reason_modal_loader').show();
                },
                success: function (data) {
                    $('#reason_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#reason_modal').modal('hide');
                            $('#reason_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }
    });

    // --------------------->for edit < -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
    
    $(document).on('click', '.edit', function () {
        $('#reason_form')[0].reset();
        $('#name_error').html('');
        var id = $(this).attr('id');
        $('#reason_modal').modal('show');
        // alert(id);
        $.ajax({
            url: "/control/cancel-reason/" + id + "/edit",
            dataType: "json",
            beforeSend: function(){
                $('#reason_modal_loader').show();
            },
            success: function (data) {
                $('#name').val(data.reason.name);
                $('#hidden_id').val(data.reason.id);
                $('#action_button').html("Update");
                $('#action').val("Edit");
                $('#reason_modal_title').text("Edit Reason");
                $('#reason_modal_loader').hide();
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