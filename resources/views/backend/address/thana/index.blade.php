@extends('layouts.back')

@section('title', 'Thana')

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
                    <h2><strong>Thana</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table border table-bordered table-hover w-100" id="thana_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>Thana</th>
                                    <th>District</th>
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
<div class="modal fade" id="thana_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="thana_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="thana_modal_title">Add Thana</h4>
            </div>
            <form id="thana_form" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Thana name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span style="color: red" id="name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="district_id">District</label>
                        <select class="form-control" name="district_id" id="district_id">
                            <option selected disabled value="">--select district--</option>

                        </select>
                        <span style="color: red" id="district_id_error"></span>
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
    $('#name').keyup(function (event) {
        $('#name_error').html('');
    });

    $('#district_id').change(function(event) {
        $('#district_id_error').html('');
    });

    function getDistrict() {
        $.ajax({
            url: '{{ route("admin.district.get")}}',
            type: 'get',
            success:function(data){
                if(data.district == ''){
                    $('#district').html('');
                    $('#district').append('<option value="">No District Found</option>');
                }else{
                    $('#district_id').html('');
                    $('#district_id').append('<option value="">Select District</option>');
                    $('#district_id').append(data.district);
                }
                
            }
            
        });
    }

    function resetError() {
        $('#district_id_error').html('');
        $('#name_error').html('');
    }

    function resetForm() {
        $('#thana_form')[0].reset();
    }


    $('#thana_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.thana.index') }}",
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
            data: 'district',
            name: 'district'
        },

        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    $('#add_new').click(function() {
        resetForm();
        resetError();
        getDistrict();
        $('#thana_modal_title').text("Add New Thana");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#thana_modal').modal('show');
    });

    $('#thana_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            $.ajax({
                url: "{{ route('admin.thana.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#thana_modal_loader').show();
                },
                success: function (data) {
                    $('#thana_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                        $('#district_id_error').html(data.errors.district_id);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#thana_modal').modal('hide');
                            $('#thana_table').DataTable().ajax.reload();
                        });
                    }

                }
            })
        }


        // ============for update =================================================================

        if ($("#action").val() == "Edit") {
            $.ajax({
                url: "{{ route('admin.thana.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#thana_modal_loader').show();
                },
                success: function (data) {
                    $('#thana_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                        $('#district_id_error').html(data.errors.district_id);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#thana_modal').modal('hide');
                            $('#thana_table').DataTable().ajax.reload();
                        });
                    }

                }
            })
        }
    });
    //-- -- -- -- -- -- -- -- -- -- - >for edit < -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

    $(document).on('click', '.edit', function () {
        resetError();
        resetForm();
        var id = $(this).attr('id');
        $('#thana_modal').modal('show');
        // alert(id); 
        $.ajax({
            url: "/control/thana/" + id + "/edit",
            dataType: "json",
            beforeSend: function(){
                $('#thana_modal_loader').show();
            },
            success: function (data) {
                $('#thana_modal_loader').hide();
                //console.log(data);
                $('#name').val(data.thana.name);

                $('#district_id').html('');
                $('#district_id').append('<option selected disabled value="">--select district--</option>');
                $('#district_id').append(data.district)

                $('#hidden_id').val(data.thana.id);
                $('#action_button').html("update");
                $('#action').val("Edit");
                $('#thana_modal_title').text("Edit Thana");
            }
        })
    });


    //========================>for delete =========================
    var Thana_id;

    $(document).on('click', '.delete', function () {
        thana_id = $(this).attr('id');
        console.log(thana_id);
        $('#confirmModal').modal('show');

        $('#ok_button').click(function () {
            $.ajax({
                url: "/control/thana/delete/" + thana_id,
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
                            $('#thana_form')[0].reset();
                            $('#thana_table').DataTable().ajax.reload();
                        });
                    }else if(data.error){
                        swal({
                            title: "Error!",
                            text: data.error,
                            icon: "warning",
                            button: "Ok!",
                        }).then((success) => {
                            $('#thana_form')[0].reset();
                            $('#thana_table').DataTable().ajax.reload();
                        });
                    }
                }
            })
        });
    });

</script>


@endsection