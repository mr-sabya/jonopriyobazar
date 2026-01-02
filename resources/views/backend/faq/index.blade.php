@extends('layouts.back')

@section('title', 'Faq')

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
                    <h2><strong>Faq</strong> Add </h2>
                </div>
                <div class="body">

                    <form action="{{ route('admin.faq.store') }}" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea class="form-control" id="question" name="question"></textarea>
                            @if($errors->has('question'))
                            <span style="color: red">{{ $errors->first('question')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" id="answer" name="answer"></textarea>
                            @if($errors->has('answer'))
                            <span style="color: red">{{ $errors->first('answer')}}</span>
                            @endif
                        </div>
                        

                        <button type="submit" class="btn btn-primary waves-effect">Save</button>



                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">

                <div class="header">
                    <h2><strong>Faq</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="faq_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Question</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faqs as $faq)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>
                                        <a href="{{ route('admin.faq.edit', $faq->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" data-route="{{ route('admin.faq.destroy', $faq->id)}}" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- add/edit modal -->


<!--  for modal showing delete -->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <form id="delete_form" action="" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')


@include('backend.partials.datatable.js')

<script>

    $('#faq_table').DataTable();

    $('.delete').click(function(event) {
        var url = $(this).attr('data-route');
        $('#delete_form').attr('action', url);
        $('#confirmModal').modal('show');
    });

</script>


@endsection