@extends('layouts.back')

@section('title', 'Wallet Package')



@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">


        <div class="col-md-4">
            <div class="card">

                <div class="header">
                    <h2><strong>Wallet Package</strong> Add </h2>
                </div>
                <div class="body">
                    <form id="package_form" method="post" enctype="multipart/form">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount">
                            <span style="color: red" id="amount_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="validate">Validity (days)</label>
                            <input type="text" class="form-control" id="validate" name="validate">
                            <span style="color: red" id="validate_error"></span>
                        </div>

                        <div>
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <button id="action_button" type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">

                <div class="header">
                    <h2><strong>Wallet Package</strong> List </h2>
                </div>
                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100" id="package_table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th>Amount</th>
                                    <th>Validity(days)</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- for modal showing delete --}}
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
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


    $('#package_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.walletpackage.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'validate',
            name: 'validate'
        },

        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
    });

    function errorReset() {
        $('#amount_error').html('');
        $('#validate_error').html('');
    }

    $('#amount').keyup(function(event) {
        if($(this).val() != ''){
            $('#amount_error').html('');
        }
    });

    $('#validate').keyup(function(event) {
        if($(this).val() != ''){
            $('#validate_error').html('');
        }
    });

    $('#package_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            $.ajax({
                url: "{{ route('admin.walletpackage.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    
                    if (data.errors) {
                        $('#amount_error').html(data.errors.amount);
                        $('#validate_error').html(data.errors.validate);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            errorReset();
                            $('#package_form')[0].reset();
                            $('#package_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }

        
        // -------------> for update <-------------------------------- 
        if ($('#action').val() == 'Edit') {
            $.ajax({
                url: "{{ route('admin.walletpackage.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    
                    if (data.errors) {
                        $('#amount_error').html(data.errors.amount);
                        $('#validate_error').html(data.errors.validate);
                    }
                    if (data.success) {
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            errorReset();
                            $('#package_form')[0].reset();
                            $('#package_table').DataTable().ajax.reload();
                        });
                        
                    }
                    
                }
            })
        }
    });

    // --------------------->for edit < -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
    
    $(document).on('click', '.edit', function () {
        $('#package_form')[0].reset();
        errorReset();
        var id = $(this).attr('id');
        // alert(id);
        $.ajax({
            url: "/control/wallet-package/" + id + "/edit",
            dataType: "json",
            success: function (data) {
                $('#amount').val(data.package.amount);
                $('#validate').val(data.package.validate);
                $('#hidden_id').val(data.package.id);
                $('#action_button').html("Update");
                $('#action').val("Edit");
            }
        })
    });


    //========================>for delete =========================
    var district_id;

    $(document).on('click', '.delete', function () {
        district_id = $(this).attr('id');
        $('#confirmModal').modal('show');

        $('#ok_button').click(function () {
            $.ajax({
                url: "/control/district/delete/" + district_id,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('Ok');
                    if(data.success){
                        swal({
                            title: "Good job!",
                            text: data.success,
                            icon: "success",
                            button: "Ok!",
                        }).then((success) => {
                            $('#district_form')[0].reset();
                            $('#district_table').DataTable().ajax.reload();
                        });
                    }else if(data.error){
                        swal({
                            title: "Error!",
                            text: data.error,
                            icon: "warning",
                            button: "Ok!",
                        }).then((success) => {
                            $('#district_form')[0].reset();
                            $('#district_table').DataTable().ajax.reload();
                        });
                    }
                    
                }
            })
        });
    });

</script>


@endsection