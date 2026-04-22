<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ url('assets/backend/images/logo-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ url('assets/backend/images/logo-dark.png') }}" alt="" height="26">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ url('assets/backend/images/logo-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ url('assets/backend/images/logo-light.png') }}" alt="" height="26">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Main Menu</span></li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link menu-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" wire:navigate>
                        <i class="bi bi-speedometer2"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <!-- ADMINISTRATION SECTION -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-admin">Administration</span></li>

                @can('admin.permissions.index')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link menu-link {{ Route::is('admin.permissions.*') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-shield-keyhole-line"></i> <span data-key="t-permissions">Permissions</span>
                    </a>
                </li>
                @endcan


                @can('admin.roles.index')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link menu-link {{ Route::is('admin.roles.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-account-circle-line"></i> <span data-key="t-roles">All Roles</span>
                    </a>
                </li>
                @endcan


                @if(Auth::user()->can('admin.admins.index') || Auth::user()->can('admin.admins.create'))
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.admins.*') ? 'active' : '' }}" href="#sidebarAdmins" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdmins">
                        <i class="ri-user-settings-line"></i> <span data-key="t-admins">Admins</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.admins.*') ? 'show' : '' }}" id="sidebarAdmins">
                        <ul class="nav nav-sm flex-column">
                            @can('admin.admins.index')
                            <li class="nav-item">
                                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ Route::is('admin.admins.index') ? 'active' : '' }}" wire:navigate>All Admins</a>
                            </li>
                            @endcan
                            @can('admin.admins.create')
                            <li class="nav-item">
                                <a href="{{ route('admin.admins.create') }}" class="nav-link {{ Route::is('admin.admins.create') ? 'active' : '' }}" wire:navigate>Add New</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif

                <!-- SHOP & CATALOG SECTION -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-shop">Shop Catalog</span></li>

                @can('category.index')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.category.*') ? 'active' : '' }}" href="#sidebarCategory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCategory">
                        <i class="ri-stack-line"></i> <span data-key="t-category">Category</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.category.*') ? 'show' : '' }}" id="sidebarCategory">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.category.index') }}" class="nav-link {{ Route::is('admin.category.index') ? 'active' : '' }}" wire:navigate>All Categories</a></li>
                            
                        </ul>
                    </div>
                </li>
                @endcan

                @can('products')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.products.*') ? 'active' : '' }}" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-shopping-bag-3-line"></i> <span data-key="t-products">Products</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.products.*') ? 'show' : '' }}" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.products.index') }}" class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}" wire:navigate>All Products</a></li>
                            <li class="nav-item"><a href="{{ route('admin.products.create') }}" class="nav-link {{ Route::is('admin.products.create') ? 'active' : '' }}" wire:navigate>Add New</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                @can('cupon')
                <li class="nav-item">
                    <a href="{{ route('admin.cupon.index') }}" class="nav-link menu-link {{ Route::is('admin.cupon.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-coupon-2-line"></i> <span data-key="t-cupon">Cupon</span>
                    </a>
                </li>
                @endcan

                <!-- LOGISTICS & ORDERS SECTION -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-logistics">Logistics & Orders</span></li>

                @can('orders')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.order.*') || Route::is('admin.customorder.*') || Route::is('admin.medicine.*') ? 'active' : '' }}" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                        <i class="ri-shopping-cart-2-line"></i> <span data-key="t-orders">Orders</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.order.*') || Route::is('admin.customorder.*') || Route::is('admin.medicine.*') ? 'show' : '' }}" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.order.index') }}" class="nav-link {{ Route::is('admin.order.index') ? 'active' : '' }}" wire:navigate>Product Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.customorder.index') }}" class="nav-link {{ Route::is('admin.customorder.index') ? 'active' : '' }}" wire:navigate>Custom Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.medicine.index') }}" class="nav-link {{ Route::is('admin.medicine.index') ? 'active' : '' }}" wire:navigate>Medicine Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.electricity.index') }}" class="nav-link {{ Route::is('admin.electricity.index') ? 'active' : '' }}" wire:navigate>Electricity Bill</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                @can('address')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.district.index') || Route::is('admin.thana.index') || Route::is('admin.city.index') ? 'active' : '' }}" href="#sidebarAddress" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAddress">
                        <i class="ri-map-pin-line"></i> <span data-key="t-address">Address</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.district.index') || Route::is('admin.thana.index') || Route::is('admin.city.index') ? 'show' : '' }}" id="sidebarAddress">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.district.index') }}" class="nav-link {{ Route::is('admin.district.index') ? 'active' : '' }}" wire:navigate>District</a></li>
                            <li class="nav-item"><a href="{{ route('admin.thana.index') }}" class="nav-link {{ Route::is('admin.thana.index') ? 'active' : '' }}" wire:navigate>Thana</a></li>
                            <li class="nav-item"><a href="{{ route('admin.city.index') }}" class="nav-link {{ Route::is('admin.city.index') ? 'active' : '' }}" wire:navigate>City/Area</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                <!-- WALLET & FINANCIAL -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-financial">Financial</span></li>

                @can('wallet')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.walletpackage.*') || Route::is('admin.walletuser.*') ? 'active' : '' }}" href="#sidebarWallet" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarWallet">
                        <i class="ri-wallet-line"></i> <span data-key="t-wallet">Wallet Management</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.walletpackage.*') || Route::is('admin.walletuser.*') ? 'show' : '' }}" id="sidebarWallet">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.walletpackage.index') }}" class="nav-link {{ Route::is('admin.walletpackage.index') ? 'active' : '' }}" wire:navigate>Package</a></li>
                            <li class="nav-item"><a href="{{ route('admin.walletuser.index') }}" class="nav-link {{ Route::is('admin.walletuser.index') ? 'active' : '' }}" wire:navigate>User</a></li>
                            <li class="nav-item"><a href="{{ route('admin.walletrequest.index') }}" class="nav-link {{ Route::is('admin.walletrequest.index') ? 'active' : '' }}" wire:navigate>Requests</a></li>
                            <li class="nav-item"><a href="{{ route('admin.packageapplication.index') }}" class="nav-link {{ Route::is('admin.packageapplication.index') ? 'active' : '' }}" wire:navigate>Package Applications</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('admin.withdraw.index') }}" class="nav-link menu-link {{ Route::is('admin.withdraw.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-hand-coin-line"></i> <span data-key="t-withdraw">Withdrawals</span>
                    </a>
                </li>

                <!-- SETTINGS & OTHERS -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-settings">Configuration</span></li>

                @can('banner')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.banner.*') ? 'active' : '' }}" href="#sidebarBanner" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBanner">
                        <i class="ri-image-line"></i> <span data-key="t-banner">Banners</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.banner.*') ? 'show' : '' }}" id="sidebarBanner">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.banner.index') }}" class="nav-link" wire:navigate>List</a></li>
                            <li class="nav-item"><a href="{{ route('admin.banner.create') }}" class="nav-link" wire:navigate>Create</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                @can('setting')
                <li class="nav-item">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link menu-link {{ Route::is('admin.setting.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-settings-4-line"></i> <span data-key="t-setting">General Settings</span>
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('admin.faq.index') }}" class="nav-link menu-link {{ Route::is('admin.faq.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-questionnaire-line"></i> <span data-key="t-faq">FAQs</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>