
<header class="header_wrap">
    <div class="middle-header dark_skin" id="myHeader">
        <div class="custom-container">
            <div class="nav_block">
                <a class="navbar-brand" href="{{ route('home')}}">
                    <img class="logo_dark" src="{{ url('upload/images', $setting->logo ) }}" alt="{{ $setting->website_name }}" />
                </a>
                <div class="product_search_form">
                    <form action="{{ route('search.index')}}" method="post">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" placeholder="Search Product..." required="" name="search" type="text">
                            <button type="submit" class="search_btn"><i class="lnr lnr-magnifier"></i></button>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">

                	@guest
                    <li><a href="{{ route('login')}}" class="nav-link"><i class="lnr lnr-user"></i></a></li>
                    @else
                    <li><a href="{{ route('user.profile')}}" class="nav-link"><i class="lnr lnr-user"></i></a></li>
                    <li>
                        <a href="{{ route('wishlist.index')}}" class="nav-link"><i class="lnr lnr-heart"></i>
                            <span class="wishlist_count" id="wishlist_count">
                                {{ Auth::user()->wishlist->count()}}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.notification.index') }}" class="nav-link">
                            <i class="lnr lnr-alarm"></i>
                            <span class="notification_count" id="notification_count">
                                @if(Auth::user()->unreadNotifications->count()>0)
                                {{ Auth::user()->unreadNotifications->count() }}
                                @else
                                0
                                @endif
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i style="color:#43a047; font-weight:bold" class="lnr lnr-power-switch"></i>
                            
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                    
                    @endguest
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
        <div class="custom-container">
            <div class="row"> 
                <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                    <div class="categories_wrap">
                        <button id="{{ Route::is('home') ? '' : 'menu_button' }}" type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn">
                            <i class="lnr lnr-menu"></i><span>All Categories </span>
                        </button>
                        <div id="navCatContent" class="nav_cat navbar collapse {{ Route::is('home') ? '' : 'sub-menu' }}">
                            <ul>


                                @php
                                $menucategories = \App\Models\Category::with('sub')->where('p_id', 0)->get();

                                @endphp
                                @foreach($menucategories as $menucategory)
                                @if($menucategory->sub->count()>0)
                                <li class="dropdown dropdown-mega-menu {{ $loop->index >= 12 ? 'more_slide_open' : '' }}">
                                    <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"> <span>{{ $menucategory->name }}</span></a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu">
                                            @foreach($menucategory->sub as $sub)
                                            @if($sub->sub->count()>0)
                                            <li class="dropdown sub-dropdown">
                                               <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"><span>{{ $sub->name }}</span></a>
                                               <div class="sub-dropdown-menu show-sub">
                                                <ul> 
                                                    @foreach($sub->sub as $subcat)
                                                    <li><a class="dropdown-item nav-link nav_item" href="{{ route('category.sub', $subcat->slug)}}">{{ $subcat->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        @else
                                        <li class="dropdown ">
                                           <a class="dropdown-item nav-link" href="{{ route('category.sub', $sub->slug)}}"><span>{{ $sub->name }}</span></a>

                                       </li>
                                       @endif

                                       @endforeach

                                   </ul>
                               </div>
                           </li>
                           @else

                           <li class="{{ $loop->index >= 12 ? 'more_slide_open' : '' }}"><a class="dropdown-item nav-link nav_item" href="{{ route('category.sub', $menucategory->slug) }}"><span>{{ $menucategory->name }}</span></a></li>
                           @endif
                           @endforeach

                       </ul>
                       <div class="more_categories">More Categories</div>
                   </div>
               </div>
           </div>
           <div class="col-lg-9 col-md-8 col-sm-6 col-9">
            <nav class="navbar navbar-expand-lg">
                 
                <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false"> 
                    <span class="fa fa-bars"></span>
                </button>
                
                <button class="navbar-toggler side_navbar_toggler" type="button"> 
                    <span class="fas fa-search"></span>
                </button>
                <div class="pr_search_icon">
                    <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                </div> 
                <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                    <ul class="navbar-nav">
                        <li>
                            <a class="nav-link nav_item {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home')}}">Home</a>  
                        </li>

                        <li>
                            <a class="nav-link nav_item {{ Route::is('category.index') ? 'active' : '' }}" href="{{ route('category.index') }}">Category</a>  
                        </li>

                        <li>
                            <a class="nav-link nav_item {{ Route::is('product.index') ? 'active' : '' }}" href="{{ route('product.index') }}">Shop</a>  
                        </li>

                        <li>
                            <a class="nav-link nav_item {{ Route::is('custom.order') ? 'active' : '' }}" href="{{ route('custom.order') }}">Custom Oder</a>  
                        </li>

                        <li>
                            <a class="nav-link nav_item {{ Route::is('electricity.index') ? 'active' : '' }}" href="{{ route('electricity.index')}}">Electricity Bill Payment</a>  
                        </li>

                        <li><a class="nav-link nav_item {{ Route::is('medicine.index') ? 'active' : '' }}" href="{{ route('medicine.index')}}">Medicine</a></li> 
                    </ul>
                </div>
                <div class="contact_phone contact_support">
                    @guest
                    <a href="javascript:void(0)" class="modal-login"><i class="fas fa-wallet"></i>

                        <span>My Wallet</span>
                    </a>
                    @else
                    <a class="mr-3" href="{{ route('user.wallet') }}"><i class="fas fa-wallet"></i>
                        <span>My Wallet</span>
                    </a>
                    
                    @endguest
                </div>
            </nav>
        </div>
    </div>
</div>
</div>
</header>