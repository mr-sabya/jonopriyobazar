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
    
    <style>
        .login_wrap .userinput{
	display: flex;
	justify-content: center;
}

.login_wrap .userinput input{
	margin: 10px;
	height: 45px;
	width: 65px;
	border: none;
	border-radius: 5px;
	text-align: center;
	font-family: arimo;
	font-size: 1.2rem;
	background: #ffffff;
	border: 1px solid #d5d4d4;

}
    </style>

</head>

<body>

    @if(Route::is('home'))
    <!-- LOADER -->
    <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
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
    @include('front.partials.header')
    <!-- END HEADER -->

    
    <div id="cart" class="shopping_cart">
        <div class="cart_close_btn">
            <a href="javascript:void(0)" style="">Close</a>
        </div>
        <div class="shopping_cart_inner">
            <div class="cart-quantiry">
                @guest
                <i class="lnr lnr-cart"></i> <span id="view_cart_top">0</span>  ITEMS
                @else
                <i class="lnr lnr-cart"></i> <span id="view_cart_top">{{ Auth::user()->cartItems->sum('quantity') }}</span>  ITEMS
                @endguest
            </div>
            
            @guest
            <div class="cart_product">

                <span style="font-size: 48px;color: #ddd;text-align: center;display: block;margin-top: 200px; line-height: 60px;">Nothing to show</span>
            </div>
            @else
            <div id="cart_product" class="cart_product">

            </div>
            <div class="cart_footer">
                <p id="subtotal" class="cart-total">
                    <strong>Subtotal:</strong><span class="float-right"><span class="price_symbole">৳</span><span class="cart_price" id="cart_price"> {{ Auth::user()->cartItems->sum('price') }}</span></span>
                </p>
                
                <a href="{{ route('checkout.index') }}" class="btn btn-success checkout w-100">Checkout</a>
                
            </div>
            @endguest
        </div>
    </div>

    <!-- cart button -->
    <section class="stickyCart" id="get_cart">
        <div class="cartItem">
            <div class="cart-icon" style="padding: 4px 0; font-size: 20px">
                <i class="fas fa-shopping-cart"></i>
            </div>
            @guest
            <span>0 ITEMS</span>
            @else
            <span><span id="view_cart">{{ Auth::user()->cartItems->sum('quantity') }}</span> ITEMS</span>
            @endguest
        </div>
        <div class="total">
            <p> ৳ <span id="view_subtotal" class="odometer-value">@guest 0 @else {{ Auth::user()->cartItems->sum('price') }} @endguest</span></p>
        </div>
    </section>

    <!-- START SECTION BANNER -->
    @if(!Route::is('home'))

    
    @endif
    <!-- END SECTION BANNER -->

    <!-- END MAIN CONTENT -->
    @yield('content')
    <!-- END MAIN CONTENT -->

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->

    <!-- START FOOTER -->
    <footer class="bg_gray">
        <div class="footer_top small_pt pb_20">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="widget">
                            <div class="footer_logo">
                                <a href="#"><img src="{{ url('upload/images', $setting->footer_logo) }}" alt="{{ $setting->website_name }}"/></a>
                            </div>
                            <p class="mb-3">জনপ্রিয়বাজার একটি অনলাইন প্রতিষ্ঠান। আমাদের সেবা এখন শুধু খুলনা শহরে পাওয়া যাবে। গ্রাহকরা এলাকার দোকানের মতই অনলাইনে ও জনপ্রিয়বাজার থেকে বাকীতে পণ্য ক্রয়ের সুবিধা ভোগ করতে পারবে। আমরাই প্রথম অনলাইনে বাকীতে পণ্য ক্রয় করার সুবিধা দিচ্ছি। </p>
                            <ul class="contact_info">
                                <li>
                                    <i class="ti-location-pin"></i>
                                    <p>160/11, Sonadanga Residential Area, 1st Phase, Khulna-9100</p>
                                </li>
                                <li>
                                    <i class="ti-email"></i>
                                    <a href="mailto:jonopriyobazar@gmail.com">jonopriyobazar@gmail.com</a>
                                </li>
                                <li>
                                    <i class="ti-mobile"></i>
                                    <p>+88 01322 882568</p>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">Useful Links</h6>
                            <ul class="widget_links">
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('faq') }}">FAQ</a></li>
                                <li><a href="{{ route('terms') }}">Terms of Use</a></li>
                                <li><a href="{{ route('refer')}}">Refer Policy</a></li>
                                <li><a href="{{ route('privacy')}}">Privacy Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widget">
                            <div class="icon_box icon_box_style2">

                                <div class="icon">
                                    <img src="{{ url('frontend/images/homdelivery.png')}}" style="width: 50px"/>
                                </div>

                                <div class="icon_box_content">
                                    <h5>Delivery Charge 10 Taka in City</h5>
                                </div>
                            </div>



                            <div class="icon_box icon_box_style2">
                                <div class="icon">
                                    <img src="{{ url('frontend/images/money_back.png')}}" style="width: 50px"/>
                                </div>
                                <div class="icon_box_content">
                                    <h5>10 Day Returns Guarantee</h5>
                                </div>
                            </div>
                            <div class="icon_box icon_box_style2">
                                <div class="icon">
                                    <img src="{{ url('frontend/images/wallet.png')}}" style="width: 50px"/>
                                </div>
                                <div class="icon_box_content">
                                    <h5>Benefit of Credit Wallet</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="widget">
                            <h6 class="widget_title">Support & Help</h6>
                            <ul class="contact_info">
                                <li>
                                    <i class="ti-mobile"></i>
                                    <p>+88 01322 882568</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="bottom_footer border-top-tran">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4">
                        <p class="mb-lg-0 text-center">{!! $setting->copyright !!}</p>
                        <p class="mb-lg-0 text-center">Developed By : <a href="https://www.facebook.com/sabya.info" target="_blank">Sabya Roy</a></p>
                    </div>
                    <div class="col-lg-4 order-lg-first">
                        <div class="widget mb-lg-0">
                            <ul class="social_icons text-center text-lg-left">
                                <li><a href="https://www.facebook.com/jonopriyobazar.com.khulna" target="_blank" class="sc_facebook"><i class="fab fa-facebook"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCU3gcuwLF7jfkptvghi66Og" class="sc_youtube" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                <!-- <li><a href="#" class="sc_google"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#" class="sc_youtube"><i class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="#" class="sc_instagram"><i class="ion-social-instagram-outline"></i></a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ul class="footer_payment text-center text-lg-right">
                            <li><a href="#"><img src="{{ url('frontend/images/visa.png') }}" alt="visa"></a></li>
                            <li><a href="#"><img src="{{ url('frontend/images/master_card.png') }}" alt="master_card"></a></li>
                            <li><a href="#"><img src="{{ url('frontend/images/amarican_express.png') }}" alt="amarican_express"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 

    <!-- Latest jQuery -->
    <script src="{{ asset('frontend/js/jquery-2.2.4.js') }}"></script>
    <!-- popper min js -->
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('frontend/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('frontend/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup min js  -->
    <script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
    <!-- waypoints min js  -->
    <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <!-- parallax js  -->
    <script src="{{ asset('frontend/js/parallax.js') }}"></script>
    <!-- countdown js  -->
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- isotope min js -->
    <script src="{{ asset('frontend/js/isotope.min.js') }}"></script>
    <!-- jquery.dd.min js -->
    <script src="{{ asset('frontend/js/jquery.dd.min.js') }}"></script>
    <!-- slick js -->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>

    <script src="{{ asset('frontend/js/sweetalert.all.min.js') }}"></script>

    <!-- scripts js -->
    <script src="{{ asset('frontend/js/scripts.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    <script>
        // ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(Session::has('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ Session::get("success")}}',
            showConfirmButton: false,
            timer: 1500
        })
        @endif
    </script>

    
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

    @if(!Route::is('login'))
    <script src="{{ asset('frontend/js/login.js') }}"></script>
    @endif
    <script src="{{ asset('frontend/js/cart.js') }}"></script>

    @yield('script')
    
    
    <!--messenger-->
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <!-- <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "101957694562930");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script> -->

    <!-- Your SDK code -->
    <!-- <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v13.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> -->



</body>
</html>