<footer class="bg_gray">
    <div class="footer_top small_pt pb_20">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="widget">
                        <div class="footer_logo">
                            <a href="#"><img src="{{ url('upload/images', $setting->footer_logo) }}" alt="{{ $setting->website_name }}" /></a>
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
                                <img src="{{ url('frontend/images/homdelivery.png')}}" style="width: 50px" />
                            </div>

                            <div class="icon_box_content">
                                <h5>Delivery Charge 10 Taka in City</h5>
                            </div>
                        </div>



                        <div class="icon_box icon_box_style2">
                            <div class="icon">
                                <img src="{{ url('frontend/images/money_back.png')}}" style="width: 50px" />
                            </div>
                            <div class="icon_box_content">
                                <h5>10 Day Returns Guarantee</h5>
                            </div>
                        </div>
                        <div class="icon_box icon_box_style2">
                            <div class="icon">
                                <img src="{{ url('frontend/images/wallet.png')}}" style="width: 50px" />
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