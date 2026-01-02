@extends('layouts.back')

@section('title', 'Edit Faq')

@section('button')
<button class="btn btn-success btn-icon float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"></i></button>
@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">


        <div class="col-md-5">
            <div class="card">

                <div class="header">
                    <h2><strong>Faq</strong> Edit </h2>
                </div>
                <div class="body">

                    <form action="{{ route('admin.faq.update', $faq->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea class="form-control" id="question" name="question">{{ $faq->question }}</textarea>
                            @if($errors->has('question'))
                            <span style="color: red">{{ $errors->first('question')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" id="answer" name="answer">{{ $faq->answer }}</textarea>
                            @if($errors->has('answer'))
                            <span style="color: red">{{ $errors->first('answer')}}</span>
                            @endif
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


@endsection