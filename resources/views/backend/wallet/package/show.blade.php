@extends('layouts.back')

@section('title', 'Package Request')

@section('content')

<div class="container-fluid customer">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-4">
            <div class="card">
                <div class="body">
                    <div class="text-center">
                        <div class="avatar">
                            @if($user->image == null)
                            <img src="{{ Avatar::create('John Doe')->toBase64() }}" alt="{{ $user->name }}">
                            @else
                            <img src="{{ url('upload/profile_pic', $user->image)}}" alt="{{ $user->name }}">
                            @endif
                            @if($user->is_varified == 1)
                            <span class="verify-status active"><i class="zmdi zmdi-check-circle"></i></span>
                            @else
                            <span class="verify-status deactive"><i class="zmdi zmdi-close-circle"></i></span>
                            @endif
                        </div>
                    </div>
                    <div class="name">
                        <h3>{{ $user->name}}</h3>
                        <p>{{ $user->phone }}</p>
                        <div class="status">
                            @if($user->status == 1)
                            <span class="badge badge-success">Active</span>
                            @elseif($user->status == 2)
                            <span class="badge badge-warning">Hold</span>
                            @else
                            <span class="badge badge-danger">Deactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="wallet_status text-center">
                        Wallet Sttatus : 
                        @if($user->is_wallet == 1)
                        <span class="badge badge-success">Active</span>
                        @elseif($user->is_wallet == 0)
                        <span class="badge badge-warning">Deactive</span>
                        @endif
                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">

                <div class="body">



                    <div class="container">
                        <h3>Wallet Info</h3>

                        <p class="m-0">National ID</p>
                        <div class="row">
                            @if($user->n_id_front != null)
                            <div class="col-6">
                                <img src="{{ url('upload/images', $user->n_id_front)}}" class="w-100">
                            </div>
                            <div class="col-6">
                                <img src="{{ url('upload/images', $user->n_id_back)}}" class="w-100">
                            </div>
                            @endif
                        </div>
                        <a href="javascript:void(0)" data-url="{{ route('admin.wallet.hold', $user->id)}}" id="wallet_hold" class="btn btn-warning mt-3">Hold</a>

                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <button id="apply_package" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Add Package</button>
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package</th>
                                    <th>Apply At</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($packages)>0)
                                @foreach($packages as $package)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $package->package->amount }} - {{ $package->package->validate }} Days</td>
                                    <td> {{ date('d-m-Y', strtotime($package->created_at)) }}</td>

                                    <td> 
                                        @if($package->valid_from != null)
                                        {{ date('d-m-Y h:i A', strtotime($package->valid_from)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->valid_to != null)
                                        {{ date('d-m-Y h:i A', strtotime($package->valid_to)) }}
                                        @endif
                                    </td>

                                    <td> 
                                        @if($package->status == 1)
                                        Currently Active
                                        @endif
                                    </td>
                                    <td>

                                        @if($package->status == 0)
                                        <a href="{{ route('admin.packageapplication.approve', $package->id)}}" type="button" id="{!! $package->id !!}" class="btn btn-table waves-effect waves-float btn-sm waves-green">Approve</a>

                                        <a href="javascript:void(0)" data-url="{{ route('admin.packageapplication.delete', $package->id)}}" type="button" class="delete btn btn-table waves-effect waves-float btn-sm waves-red">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7">No Package Assigned</td>
                                </tr>
                                @endif
                            </tbody>
                            

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- add package -->
<div class="modal fade" id="package_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="package_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="package_modal_title">Add Package</h4>
            </div>
            <form id="package_form" method="post" action="{{ route('admin.walletpackage.assign')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{$user->id }}">
                    <div class="form-group">
                        <label for="name">Credit Wallet Package</label>
                        <select class="form-control" name="package_id" id="package_id" required>
                            <option value="" selected disabled>(Select Package)</option>
                            @foreach($packs as $pack)
                            <option value="{{ $pack->id }}">{{ $pack->amount }} - {{ $pack->validate }} Days</option>
                            @endforeach
                        </select>
                        <span style="color: red" id="name_error"></span>
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

<!-- delete modal -->
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
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
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
    // ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#wallet_approve', function () {
        $.ajax({
            url: $(this).attr('data-url'),
            
            success: function (data) {


                if(data.success){
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {
                        location.reload();
                    });
                }else if(data.error){
                    swal({
                        title: "Error!",
                        text: data.error,
                        icon: "warning",
                        button: "Ok!",
                    });
                }
                
            }
        })
    });


    $(document).on('click', '.delete', function () {
        $('#confirmModal').modal('show');
        $('#delete_form').attr('action', $(this).attr('data-url'));
    });

    $('#apply_package').click(function(event) {
        $('#package_modal').modal('show');
    });


</script>


@endsection