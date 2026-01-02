@extends('layouts.back')

@section('title', 'City/Area')

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
                    <h2><strong>City/Area</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table border table-bordered table-hover w-100" id="city_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>City</th>
                                    <th>Thana</th>
                                    <th>Delivery Charge</th>
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
<div class="modal fade" id="city_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="city_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="city_modal_title">Add City/Area</h4>
            </div>
            <form id="city_form" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="district_id">District</label>
                        <select class="form-control" name="district_id" id="district_id">
                            <option selected disabled value="">--select district--</option>
                            
                        </select>
                        <span style="color: red" id="district_id_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="thana_id">Thana</label>
                        <select class="form-control" name="thana_id" id="thana_id">
                            <option selected disabled value="">--select thana--</option>
                        </select>
                        <span style="color: red" id="thana_id_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">City/Area name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span style="color: red" id="name_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Delivery Charge</label>
                        <input type="text" class="form-control" id="delivery_charge" name="delivery_charge">
                        <span style="color: red" id="delivery_charge_error"></span>
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


<!-- for modal showing delete -->
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

    $('#district_id').change(function(event) {
        var id = $(this).val();
        $.ajax({
            url: '/control/get-thana/'+id,
            type: 'get',
            success:function(data){
                if(data.thana == ''){
                    $('#thana_id').html('');
                    $('#thana_id').append('<option value="">No Thana Found</option>');
                }else{
                    $('#thana_id').html('');
                    $('#thana_id').append('<option value="">Select Thana</option>');
                    $('#thana_id').append(data.thana);
                }
                
            }
            
        });
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
        $('#thana_id_error').html('');
        $('#name_error').html('');
        $('#delivery_charge_error').html('');
    }

    function resetForm() {
        $('#city_form')[0].reset();
        $('#thana_id').html('')
        $('#thana_id').append('<option selected disabled value="">--select thana--</option>')

    }

    $('#add_new').click(function() {
        resetForm();
        resetError();
        getDistrict();
        $('#city_modal_title').text("Add New City");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#city_modal').modal('show');
    });


    $('#name').keyup(function (event) {
        $('#name_error').html('');
    });

    $('#district_id').change(function(event) {
        $('#district_id_error').html('');
    });

    $('#thana_id').change(function(event) {
        $('#thana_id_error').html('');
    });


    $('#city_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.city.index') }}",
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
            data: 'thana',
            name: 'thana'
        },
        {
            data: 'delivery_charge',
            name: 'delivery_charge'
        },

        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    
    

    $('#city_form').on('submit', function (event) {
        event.preventDefault();
        // ============ for create ==========================================================
        if ($('#action').val() == 'Add') {
            $.ajax({
                url: "{{ route('admin.city.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#city_modal_loader').show();
                },
                success: function (data) {
                    $('#city_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                        $('#district_id_error').html(data.errors.district_id);
                        $('#thana_id_error').html(data.errors.thana_id);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            resetForm();
                            $('#city_modal').modal('hide');
                            $('#city_table').DataTable().ajax.reload();
                        });
                    }
                    
                }
            })
        }


        // ============for update =================================================================

        if ($("#action").val() == "Edit") {
            $.ajax({
                url: "{{ route('admin.city.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('#city_modal_loader').show();
                },
                success: function (data) {

                    $('#city_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                        $('#district_id_error').html(data.errors.district_id);
                        $('#thana_id_error').html(data.errors.thana_id);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            resetForm();
                            $('#city_modal').modal('hide');
                            $('#city_table').DataTable().ajax.reload();
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
        $('#city_modal').modal('show');
        // alert(id); 
        $.ajax({
            url: "/control/city/" + id + "/edit",
            dataType: "json",
            beforeSend: function(){
                $('#city_modal_loader').show();
            },
            success: function (data) {
                $('#city_modal_loader').hide();
                //console.log(data);
                $('#name').val(data.city.name);
                $('#delivery_charge').val(data.city.delivery_charge);

                $('#district_id').html('');
                $('#district_id').append('<option selected disabled value="">--select district--</option>');
                $('#district_id').append(data.district);

                $('#thana_id').html('');
                $('#thana_id').append(data.thana);

                $('#hidden_id').val(data.city.id);
                $('#action_button').html("update");
                $('#action').val("Edit");

                $('#city_modal_title').text("Edit City/Area");
                
            }
        })
    });


    //========================>for delete =========================
    var Thana_id;

    $(document).on('click', '.delete', function () {
        thana_id = $(this).attr('id');
        $('#confirmModal').modal('show');

        $('#ok_button').click(function () {
            $.ajax({
                url: "/control/city/delete/" + thana_id,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    setTimeout(function () {
                        $('#confirmModal').modal('hide');
                        $('#city_table').DataTable().ajax.reload();
                    });
                }
            })
        });
    });

</script>


@endsection