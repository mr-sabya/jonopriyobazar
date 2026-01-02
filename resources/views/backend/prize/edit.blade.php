@extends('layouts.back')

@section('title', 'Edit Prize')

@section('button')
<button class="btn btn-success btn-icon float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"></i></button>
@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-6">
            <div class="card">

                <div class="header">
                    <h2><strong>Prize</strong> Edit </h2>
                </div>
                <div class="body">
                    <form id="prize_form" method="post" action="{{ route('admin.prize.update', $prize->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $prize->title }}">
                                @if($errors->has('title'))
                                <span style="color: red">{{ $errors->first('title')}}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="point">Point</label>
                                <input type="number" class="form-control" id="point" name="point" value="{{ $prize->point }}">
                                @if($errors->has('point'))
                                <span style="color: red">{{ $errors->first('point')}}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="prize">Prize</label>
                                <input type="file" class="form-control" id="prize" name="prize" data-default-file="{{ url('upload/images', $prize->prize)}}">
                                @if($errors->has('prize'))
                                <span style="color: red">{{ $errors->first('prize')}}</span>
                                @endif
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>
                        </div>
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
    $('#prize').dropify();
</script>


@endsection