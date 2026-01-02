@extends('layouts.back')

@section('title', 'Team Member')

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Team Member</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="prize_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($teams as $team)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        <img src="{{ url('upload/images', $team->image)}}" style="width: 150px;">
                                    </td>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->designation }}</td>
                                    <td>
                                        <a href="{{ route('admin.team.edit', $team->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" data-route="{{ route('admin.team.destroy', $team->id)}}" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i>
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
    $('.delete').click(function(event) {
        var url = $(this).attr('data-route');
        $('#delete_form').attr('action', url);
        $('#confirmModal').modal('show');
    });

</script>


@endsection