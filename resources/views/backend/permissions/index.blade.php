@extends('layouts.back')

@section('title', 'Permissions')

@section('button')
<!-- <a href="{{ route('admin.roles.create')}}" class="btn btn-success float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"> Role</i></a> -->
@endsection

@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-4">
            <div class="card">

                <div class="header">
                    <h2><strong>Permission</strong> Create </h2>
                </div>
                <div class="body">
                    <form id="permission_form" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="name">Permission</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <small id="name_error" style="color: red"></small>
                            </div>
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="group_name">Group Name</label>
                                <input type="text" class="form-control" id="group_name" name="group_name">
                                <small id="group_name_error" style="color: red"></small>
                            </div>
                        </div>
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <button type="submit" id="action_button" class="btn btn-primary waves-effect">Save</button>
                        <button type="submit" id="reset_button" class="btn btn-secondary waves-effect">Reset</button>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">

                <div class="header">
                    <h2><strong>Permission</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="permission_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="40%">Name</th>
                                    <th width="30%">Group Name</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
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


@endsection

@section('scripts')

@include('backend.partials.datatable.js')

<script>
    $('#permission_table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: "{{ route('admin.permissions.index') }}",
        },
        columns:[
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
            data: 'group_name',
            name: 'group_name'
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

    $('#group_name').keyup(function(event) {
        if($(this).val() != ''){
            $('#group_name_error').html('');
        }
    });

    $('#reset_button').click(function(event) {
        $('#action_button').val('Add');
        $('#permission_form')[0].reset();
        $('#action_button').html('Save');
    });

    $('#permission_form').on('submit', function(event){
        event.preventDefault();
        if($('#action').val() == 'Add')
        {
            $.ajax({
                url:"{{ route('admin.permissions.store') }}",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data)
                {

                    if(data.errors)
                    {
                        $('#name_error').html(data.errors.name);
                        $('#group_name_error').html(data.errors.group_name);
                    }
                    
                    if(data.success)
                    {
                        $('#permission_form')[0].reset();
                        $('#permission_table').DataTable().ajax.reload();
                    }
                }
            });
        }

        if($('#action').val() == 'Edit')
        {
            $.ajax({
                url:"{{ route('admin.permissions.update') }}",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data)
                {

                    if(data.errors)
                    {
                        $('#name_error').html(data.errors.name);
                        $('#group_name_error').html(data.errors.group_name);
                    }
                    
                    if(data.success)
                    {
                        $('#permission_form')[0].reset();
                        $('#permission_table').DataTable().ajax.reload();
                    }
                }
            });
        }

    });


    $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $('#name_error').html('');
        $('#group_name_error').html('');
        $.ajax({
            url:"/control/permissions/"+id+"/edit",
            dataType:"json",
            success:function(html){
                $('#name').val(html.permission.name);
                $('#group_name').val(html.permission.group_name);

                $('#hidden_id').val(html.permission.id);
                
                $('#action_button').html("Update");
                $('#action').val("Edit");
            }
        })
    });
</script>

@endsection
