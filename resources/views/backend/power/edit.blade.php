@extends('layouts.back')

@section('title', 'Edit Power Distribution Company')

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-6">
            <div class="card">

                <div class="header">
                    <h2><strong>Edit</strong> Power Company </h2>
                </div>
                <div class="body">

                    <form id="power_form" action="{{ route('admin.power.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="id" value="{{ $power->id}}">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $power->name }}">
                                <span style="color: red" id="name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="name">Type</label>
                                <input type="text" class="form-control" id="type" name="type" value="{{ $power->type }}">
                                <span style="color: red" id="type_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo" data-default-file="{{ url('upload/images', $power->logo) }}">
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
    </div>

</div>




@endsection


@section('scripts')


@include('backend.partials.datatable.js')
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>

    $('#logo').dropify();

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
                if (data.route) {
                    window.location = data.route;

                }

            }
        })

    });

    

</script>


@endsection