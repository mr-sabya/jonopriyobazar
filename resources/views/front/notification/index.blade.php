@extends('layouts.front')

@section('title')
Notifications
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="custom-container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-right mb-3">
                        <a href="javascript:void(0)" id="all_read" class="btn btn-primary">Mark all as read</a>
                    </div>
                    <div class="row" id="notification_data">
                        @include('front.notification.partials.list')
                    </div>
                    <div class="row load-more">
                        <div class="col-12 text-center">
                            <div class="load">


                                <button class="btn btn-dark" id="load_more">Load More</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->


</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script>
    $(document).ready(function(){


        function lodeMoreData(page) {
            $.ajax({
                url: '/fetch/notifications?page=' + page,
                type: 'get',
                beforeSend: function() {
                    $("#load_more").html('Loading..');
                }
            })
            .done(function(data) {
                if (data == '') {
                    $("#load_more").html('no more notification found');
                    return;
                }
                $("#load_more").html('Load More');
                $('#notification_data').append(data);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('Server not responding...');
            });

        }

        var page = 1;

        $('#load_more').click(function(event) {
            page++;
            lodeMoreData(page);
        });

        
    });


    $(document).on('click', '#all_read', function() {
        $.ajax({
            url:"{{ route('user.notification.read')}}",
            success:function(data)
            {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1500
                });

                $.ajax({
                    url: '/fetch/notifications',
                    type: 'get',
                })
                .done(function(data) {
                    
                    $('#notification_data').html(data);
                    $('#notification_count').html(0);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server not responding...');
                });
                
            }
        });
    });





</script>
@endsection