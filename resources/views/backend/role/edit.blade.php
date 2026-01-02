@extends('layouts.back')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Edit</strong> Role </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                            @if ($errors->has('name'))
                            <span id="slug_error" style="color: red">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\Admin::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                            <div class="row">
                                @php
                                $permissions = App\Models\Admin::getpermissionsByGroupName($group->name);
                                $j = 1;
                                @endphp

                                <div class="col-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\Admin::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                    </div>
                                </div>

                                <div class="col-9 role-{{ $i }}-management-checkbox">

                                    @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @php  $j++; @endphp
                                    @endforeach
                                    <br>
                                </div>

                            </div>
                            @php  $i++; @endphp
                            @endforeach
                        </div>
                        <button type="submit"class="btn btn-primary waves-effect">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')

@include('backend.role.partials.script')
<script>



    @if(Session::has('success'))
    swal({
        title: "Good job!",
        text: "{{ Session::get('success')}}",
        icon: "success",
    });
    @endif

</script>

@endsection
