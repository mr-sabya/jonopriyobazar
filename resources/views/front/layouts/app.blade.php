<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $setting = \App\Models\Setting::where('id', 1)->first();
    @endphp
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $setting->meta_desc }}">
    <meta name="keywords" content="{{ $setting->tags }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SITE TITLE -->

    @if(Route::is('home'))
    <title>{{ $setting->website_name }} - {{ $setting->tagline }}</title>
    @else
    <title>@yield('title') - {{ $setting->website_name }}</title>
    @endif

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/bootstrap/css/bootstrap.min.css') }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/simple-line-icons.css') }}">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ asset('frontend/owlcarousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/owlcarousel/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/owlcarousel/css/owl.theme.default.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">

    <!-- Bootstrap Datatable -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/summernote/summernote-lite.min.css')}}">

    <!-- Dropify -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropify/css/dropify.min.css') }}">

    @yield('css')

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    @livewireStyles
</head>

<body>

    @if(Route::is('home'))
    <!-- LOADER -->
    <!-- <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> -->
    <!-- END LOADER -->
    @endif

    <!-- Home Popup Section -->
    <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close"></i></span>
                    </button>
                    <div class="row no-gutters">
                        <div class="col-sm-7">
                            <div class="popup_content text-left">
                                <div class="popup-text">
                                    <div class="heading_s1">
                                        <h3>Subscribe Newsletter and Get 25% Discount!</h3>
                                    </div>
                                    <p>Subscribe to the newsletter to receive updates about new products.</p>
                                </div>
                                <form method="post">
                                    <div class="form-group">
                                        <input name="email" required type="email" class="form-control" placeholder="Enter Your Email">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-fill-out btn-block text-uppercase" title="Subscribe" type="submit">Subscribe</button>
                                    </div>
                                </form>
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                        <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="background_bg h-100" data-img-src="{{ url('frontend/images/popup_img3.jpg') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="login_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="validation"></div>

                    <form action="{{ route('login')}}" id="modal_login_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Your Phone Number" id="modal_login_phone" autocomplete="new-phone">
                            <small style="color: red" id="modal_login_phone_error"></small>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" placeholder="Password" id="modal_login_password" autocomplete="new-password">
                            <small style="color: red" id="modal_login_password_error"></small>
                        </div>
                        <div class="login_footer form-group">
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                        id="modal_remember" value="">
                                    <label class="form-check-label" for="modal_remember"><span>Remember
                                            me</span></label>
                                </div>
                            </div>
                            <a href="#">Forgot password?</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-fill-out btn-block">Log
                                in</button>
                        </div>
                    </form>
                    <div class="different_login">
                        <span> or</span>
                    </div>
                    <div class="form-note text-center"><a href="{{ route('register')}}">Create A New Account</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <livewire:frontend.theme.header />
    <!-- END HEADER -->


    <livewire:frontend.theme.sidecart />

    <!-- cart button -->
    <livewire:frontend.theme.cart-button />

    @if(!Route::is('home'))
    <!-- Breadcrumb Section -->
    <div class="breadcrumb-main-wrapper bg-light py-3 border-bottom">
        <div class="container-fluid custom-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0 bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-secondary text-decoration-none" wire:navigate>
                            <i class="fas fa-home small mr-1"></i> Home
                        </a>
                    </li>

                    @php $link = ""; @endphp
                    @foreach(request()->segments() as $segment)
                    @php $link .= "/" . $segment; @endphp

                    @if($loop->last)
                    <li class="breadcrumb-item active text-main-green font-weight-bold" aria-current="page">
                        {{ ucwords(str_replace('-', ' ', $segment)) }}
                    </li>
                    @else
                    <li class="breadcrumb-item">
                        <a href="{{ $link }}" class="text-secondary text-decoration-none" wire:navigate>
                            {{ ucwords(str_replace('-', ' ', $segment)) }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
    @endif

    <!-- END MAIN CONTENT -->
    @yield('content')
    <!-- END MAIN CONTENT -->


    <!-- START FOOTER -->
    <livewire:frontend.theme.footer />

    <!-- Bottom of body -->
    <livewire:frontend.components.quick-view />

    <script>
        // Listen for the event to SHOW the modal
        window.addEventListener('show-quickview-modal', event => {
            $('#quickViewModal').modal('show');
        });

        // Listen for the event to HIDE the modal
        window.addEventListener('hide-quickview-modal', event => {
            $('#quickViewModal').modal('hide');
        });
    </script>
    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <!-- Latest jQuery -->
    <script data-navigate-once src="{{ asset('frontend/js/jquery-2.2.4.js') }}"></script>
    <!-- popper min js -->
    <script data-navigate-once src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script data-navigate-once src="{{ asset('frontend/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script data-navigate-once src="{{ asset('frontend/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup min js  -->
    <script data-navigate-once src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
    <!-- waypoints min js  -->
    <script data-navigate-once src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <!-- parallax js  -->
    <script data-navigate-once src="{{ asset('frontend/js/parallax.js') }}"></script>
    <!-- countdown js  -->
    <script data-navigate-once src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <!-- imagesloaded js -->
    <script data-navigate-once src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- isotope min js -->
    <script data-navigate-once src="{{ asset('frontend/js/isotope.min.js') }}"></script>
    <!-- jquery.dd.min js -->
    <script data-navigate-once src="{{ asset('frontend/js/jquery.dd.min.js') }}"></script>
    <!-- slick js -->
    <script data-navigate-once src="{{ asset('frontend/js/slick.min.js') }}"></script>

    <script data-navigate-once src="{{ asset('frontend/js/sweetalert.all.min.js') }}"></script>

    <!-- scripts js -->
    <script data-navigate-once src="{{ asset('frontend/js/scripts.js') }}"></script>
    <script data-navigate-once src="{{ asset('frontend/js/custom.js') }}"></script>

    @if(Session::has('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ Session::get("success")}}',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
    @endif


    @if(Route::is('home'))
    <script>
        window.onscroll = function() {
            stickyHeader()
        };

        var header = document.getElementById("myHeader");
        var sticky = header.offsetTop;

        function stickyHeader() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
                $('#navCatContent').addClass('sub-menu');
            } else {
                header.classList.remove("sticky");

                $('#navCatContent').removeClass('sub-menu');
            }
        }
    </script>
    @else
    <script>
        window.onscroll = function() {
            stickyHeader()
        };

        var header = document.getElementById("myHeader");
        var sticky = header.offsetTop;

        function stickyHeader() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>
    @endif

    <script>
        // Integration with Swal if needed for toasts
        window.addEventListener('toast', event => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: event.detail[0].type,
                title: event.detail[0].message,
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
    
    @yield('script')
    @livewireScripts


</body>

</html>