@extends('layouts.back')

@section('title', 'Power Distribution Company')

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
                        <table class="table table-bordered table-hover w-100" id="power_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Type</th>
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
<div class="modal fade" id="power_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="power_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="power_modal_title">Add Power Company</h4>
            </div>
            <form id="power_form" action="{{ route('admin.power.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span style="color: red" id="name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Type</label>
                        <input type="text" class="form-control" id="type" name="type">
                        <span style="color: red" id="type_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo">
                        <span style="color: red" id="logo_error"></span>
                    </div>
                    
                </div>
                <div class="modal-footer">
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
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>

    $('#logo').dropify();

    $('#power_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.power.index') }}",
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
            data: 'company_image',
            name: 'company_image'
        },
        {
            data: 'type',
            name: 'type'
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

    $('#type').keyup(function(event) {
        if($(this).val() != ''){
            $('#type_error').html('');
        }
    });


    $('#logo').change(function(event) {
        if($(this).val() != ''){
            $('#logo_error').html('');
        }
    });

    

    

    $('#add_new').click(function() {
        $('#power_form')[0].reset();
        $('#power_modal_title').text("Add New Power Company");
        $('#power_modal').modal('show');
    });

    $('#power_form').on('submit', function (event) {
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
                    $('#power_modal_loader').show();
                },
                success: function (data) {
                    $('#power_modal_loader').hide();
                    if (data.errors) {
                        $('#name_error').html(data.errors.name);
                        $('#type_error').html(data.errors.type);
                        $('#logo_error').html(data.errors.logo);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#power_modal').modal('hide');
                            $('#power_table').DataTable().ajax.reload();
                        });

                    }

                }
            })

    });

    // --------------------->for edit < -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
    
    

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