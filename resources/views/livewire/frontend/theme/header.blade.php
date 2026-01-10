<header class="header_wrap fixed-top">
    <!-- Main Top Header -->
    <div class="middle-header bg-main-green py-2" id="myHeader">
        <div class="container-fluid custom-container">
            <div class="d-flex align-items-center justify-content-between">

                <!-- Mobile Hamburger & Logo -->
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler d-lg-none text-white mr-2" type="button" data-toggle="collapse" data-target="#navbarSidetoggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand m-0" href="{{ route('home')}}" wire:navigate>
                        <img src="{{ url('upload/images', $setting->logo ) }}" alt="{{ $setting->website_name }}" class="logo_img" />
                    </a>
                </div>

                <!-- Delivery Location (Desktop Only) -->
                <div class="delivery-location d-none d-xl-block ml-4">
                    <button class="btn btn-outline-light btn-sm d-flex align-items-center location-btn">
                        <img src="https://d2t8nl1y0ie1km.cloudfront.net/public/delivery.svg" alt="delivery" width="20" class="mr-2">
                        <div class="text-left">
                            <small class="d-block" style="font-size: 10px; line-height: 1;">Today: 6PM - 7PM</small>
                            <span style="font-size: 11px;">Select your delivery location</span>
                        </div>
                    </button>
                </div>

                <!-- Central Search Bar -->
                <livewire:frontend.theme.search />

                <!-- Right Side Actions -->
                <div class="d-flex align-items-center">
                    <!-- App Download (Desktop) -->
                    <a href="#" class="d-none d-lg-block mr-3">
                        <img src="https://d2t8nl1y0ie1km.cloudfront.net/public/app-download.png" alt="app" width="140">
                    </a>

                    <!-- Language Switcher -->
                    <div class="lang-switch d-none d-md-block mr-3">
                        <button class="btn btn-sm btn-outline-light">বাংলা</button>
                    </div>

                    <!-- User Account -->
                    <div class="user-auth-actions">
                        @guest
                        <a href="{{ route('login')}}" wire:navigate class="btn btn-outline-light btn-sm d-flex align-items-center rounded px-3">
                            <i class="lnr lnr-user mr-2"></i>
                            <span class="d-none d-lg-inline">Sign in / Sign up</span>
                        </a>
                        @else
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center" type="button" data-toggle="dropdown">
                                <i class="lnr lnr-user mr-2"></i> <span>{{ Auth::user()->name }}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('user.dashboard')}}" wire:navigate>Dashboard</a>
                                <a class="dropdown-item" href="{{ route('user.profile')}}" wire:navigate>Profile</a>
                                <a class="dropdown-item" href="{{ route('user.wallet.index') }}" wire:navigate>My Wallet</a>
                                <a class="dropdown-item" href="{{ route('wishlist.index')}}" wire:navigate>Wishlist ({{ Auth::user()->wishlist->count()}})</a>
                                <div class="dropdown-divider"></div>
                                <livewire:frontend.auth.logout />
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Navigation (Categories) -->
    <div class="bottom_header bg-white border-bottom d-none d-lg-block">
        <div class="container-fluid custom-container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <livewire:frontend.theme.category-wrap />
                </div>
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg p-0">
                        <ul class="navbar-nav">
                            <li><a class="nav-link nav_item {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home')}}" wire:navigate>Home</a></li>
                            <li><a class="nav-link nav_item {{ Route::is('category.index') ? 'active' : '' }}" href="{{ route('category.index') }}" wire:navigate>Category</a></li>
                            <li><a class="nav-link nav_item {{ Route::is('product.index') ? 'active' : '' }}" href="{{ route('product.index') }}" wire:navigate>Shop</a></li>
                            <li><a class="nav-link nav_item {{ Route::is('custom.order') ? 'active' : '' }}" href="{{ route('custom.order') }}" wire:navigate>Custom Order</a></li>
                            <li><a class="nav-link nav_item {{ Route::is('electricity.index') ? 'active' : '' }}" href="{{ route('electricity.index') }}" wire:navigate>Electricity Bill Payment</a></li>

                            <li><a class="nav-link nav_item {{ Route::is('medicine.index') ? 'active' : '' }}" href="{{ route('medicine.index')}}" wire:navigate>Medicine</a></li>
                        </ul>
                        <div class="ml-auto">
                            <a href="{{ route('user.wallet.index') }}" class="text-success font-weight-bold" wire:navigate><i class="fas fa-wallet mr-1"></i> My Wallet</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>