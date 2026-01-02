@extends('layouts.back')

@section('title', 'Create Role')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>New</strong> Role </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.admins.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                <span id="slug_error" style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">User Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                                @if ($errors->has('email'))
                                <span id="slug_error" style="color: red">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                @if ($errors->has('password'))
                                <span id="slug_error" style="color: red">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                @if ($errors->has('password_confirmation'))
                                <span id="slug_error" style="color: red">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control" multiple data-placeholder="Select Role">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        
                        <button type="submit"class="btn btn-primary waves-effect">Update User</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')

<!-- Select2 Js -->
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script> 

<script>
    $('#roles').select2();
</script>

@endsection
