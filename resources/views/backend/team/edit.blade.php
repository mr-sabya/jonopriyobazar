@extends('layouts.back')

@section('title', 'EditTeam Member')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-6">
            <div class="card">

                <div class="header">
                    <h2><strong>Team Member</strong> Edit </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.team.update', $team->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}">
                                    @if ($errors->has('name'))
                                    <span id="title_error" style="color: red">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control"  id="designation" name="designation" value="{{ $team->designation }}">
                                    @if ($errors->has('designation'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('designation') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" data-max-file-size="200K" data-height="190" @if($team->image != null) data-default-file="{{ url('upload/images', $team->image)}}" @endif>
                                    <small>Image size must be 255px X 255px</small><br>
                                    @if ($errors->has('image'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            
                        </div>
                        
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>

                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>


@endsection

@section('scripts')
<!-- Dropify -->
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>

   
    $('#image').dropify();


</script>

@endsection
