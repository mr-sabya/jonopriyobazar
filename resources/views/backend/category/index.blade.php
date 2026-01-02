@extends('layouts.back')

@section('title', 'Categories')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Art Work</strong> Category List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="category_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="10%">Image</th>
                                    <th style="text-align: left;" width="30%">Category</th>
                                    <th width="30%">Slug</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach($categories as $category)
                                
                                <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>
                                        @if($category->icon != null)
                                        <img src="{{ url('upload/images', $category->icon)}}" class="w-50">
                                        @endif
                                    </td>
                                    <td style="text-align: left;">{!! $category->name !!}</td>
                                    <td>{!! $category->slug !!}</td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $category->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" id="{!! $category->id !!}" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                @foreach($category->sub as $sub)
                                <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>
                                        @if($sub->icon != null)
                                        <img src="{{ url('upload/images', $sub->icon)}}" class="w-50">
                                        @endif
                                    </td>
                                    <td style="text-align: left;"> -- {!! $sub->name !!}</td>
                                    <td>{!! $sub->slug !!}</td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $sub->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" id="{!! $sub->id !!}" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @foreach($sub->sub as $subcat)
                                <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>
                                        @if($subcat->icon != null)
                                        <img src="{{ url('upload/images', $subcat->icon)}}" class="w-50">
                                        @endif
                                    </td>
                                    <td style="text-align: left;"> ---- {!! $subcat->name !!}</td>
                                    <td>{!! $subcat->slug !!}</td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $subcat->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" id="{!! $subcat->id !!}" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                
                                
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th style="text-align: left;">Category</th>
                                    <th>Slug</th>
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

<div id="confirm_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif') }}">
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('backend.partials.datatable.js')


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#category_table').DataTable();

    var medium_id;

    $(document).on('click', '.delete', function() {
        medium_id = $(this).attr('id');
        $('#confirm_modal').modal('show');
    });

</script>

@endsection
