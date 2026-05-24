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

                @if(Auth::user()->can('admin.products.index') || Auth::user()->can('admin.products.create'))
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.products.*') ? 'active' : '' }}" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-shopping-bag-3-line"></i> <span data-key="t-products">Products</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.products.*') ? 'show' : '' }}" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            @can('admin.products.index')
                            <li class="nav-item"><a href="{{ route('admin.products.index') }}" class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}" wire:navigate>All Products</a></li>
                            @endcan
                            @can('admin.products.create')
                            <li class="nav-item"><a href="{{ route('admin.products.create') }}" class="nav-link {{ Route::is('admin.products.create') ? 'active' : '' }}" wire:navigate>Add New</a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif

                @can('admin.coupon.index')
                <li class="nav-item">
                    <a href="{{ route('admin.coupon.index') }}" class="nav-link menu-link {{ Route::is('admin.coupon.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-coupon-2-line"></i> <span data-key="t-coupon">Coupon</span>
                    </a>
                </li>
                @endcan

                <!-- LOGISTICS & ORDERS SECTION -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-logistics">Logistics & Orders</span></li>

                @can('orders')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.order.*') ? 'active' : '' }}" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                        <i class="ri-shopping-cart-2-line"></i> <span data-key="t-orders">Orders</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.order.*') ? 'show' : '' }}" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.order.product.index') }}" class="nav-link {{ Route::is('admin.order.product.*') ? 'active' : '' }}" wire:navigate>Product Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.order.customorder.index') }}" class="nav-link {{ Route::is('admin.order.customorder.*') ? 'active' : '' }}" wire:navigate>Custom Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.order.medicine.index') }}" class="nav-link {{ Route::is('admin.order.medicine.*') ? 'active' : '' }}" wire:navigate>Medicine Order</a></li>
                            <li class="nav-item"><a href="{{ route('admin.order.electricity.index') }}" class="nav-link {{ Route::is('admin.order.electricity.*') ? 'active' : '' }}" wire:navigate>Electricity Bill</a></li>
                        </ul>
                    </div>
                </li>
                @endcan

                <!-- CUSTOMER -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-customer">Customer Management</span></li>
                @can('customer')
                <li class="nav-item">
                    <a href="{{ route('admin.customer.index') }}" class="nav-link menu-link {{ Route::is('admin.customer.index') ? 'active' : '' }}" wire:navigate>
                        <i class="ri-user-line"></i> <span data-key="t-customers">Customers</span>
                    </a>
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
                    <a class="nav-link menu-link {{ Route::is('admin.wallet.*') ? 'active' : '' }}" href="#sidebarWallet" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarWallet">
                        <i class="ri-wallet-line"></i> <span data-key="t-wallet">Wallet Management</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.wallet.*') ? 'show' : '' }}" id="sidebarWallet">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.wallet.package.index') }}" class="nav-link {{ Route::is('admin.wallet.package.index') ? 'active' : '' }}" wire:navigate>Package</a></li>
                            <li class="nav-item"><a href="{{ route('admin.wallet.user.index') }}" class="nav-link {{ Route::is('admin.wallet.user.*') ? 'active' : '' }}" wire:navigate>User</a></li>
                            <li class="nav-item"><a href="{{ route('admin.wallet.request.index') }}" class="nav-link {{ Route::is('admin.wallet.request.index') ? 'active' : '' }}" wire:navigate>Requests</a></li>
                            <li class="nav-item"><a href="{{ route('admin.wallet.application.index') }}" class="nav-link {{ Route::is('admin.wallet.application.index') ? 'active' : '' }}" wire:navigate>Package Applications</a></li>
                        </ul>
                    </div>
                </li>
                @endcan



                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.withdraw.*') || Route::is('admin.userprize.*') ? 'active' : '' }}"
                        href="#sidebarPayouts"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ Route::is('admin.withdraw.*') || Route::is('admin.userprize.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarPayouts">
                        <i class="ri-hand-coin-line"></i> <span data-key="t-payouts">Payouts & Prizes</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.withdraw.*') || Route::is('admin.userprize.*') ? 'show' : '' }}" id="sidebarPayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.withdraw.index') }}"
                                    class="nav-link {{ Route::is('admin.withdraw.index') ? 'active' : '' }}"
                                    wire:navigate>
                                    Withdrawals
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.userprize.index') }}"
                                    class="nav-link {{ Route::is('admin.userprize.index') ? 'active' : '' }}"
                                    wire:navigate>
                                    User Prizes
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- SETTINGS & OTHERS -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-settings">Configuration</span></li>

                <li class="nav-item">
                    <!-- Main Parent Link -->
                    <a class="nav-link menu-link {{ Route::is('admin.reason.*', 'admin.power.*', 'admin.prize.*', 'admin.deliverystatus.*') ? 'active' : '' }}"
                        href="#sidebarSetup" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.reason.*', 'admin.power.*', 'admin.prize.*', 'admin.deliverystatus.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarSetup">
                        <i class="ri-settings-4-line"></i> <span data-key="t-setup">Setup Management</span>
                    </a>

                    <!-- Dropdown Content -->
                    <div class="collapse menu-dropdown {{ Route::is('admin.reason.*', 'admin.power.*', 'admin.prize.*', 'admin.deliverystatus.*') ? 'show' : '' }}" id="sidebarSetup">
                        <ul class="nav nav-sm flex-column">

                            <!-- Cancel Reason Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.reason.index') }}"
                                    class="nav-link {{ Route::is('admin.reason.*') ? 'active' : '' }}"
                                    wire:navigate>
                                    Cancel Reasons
                                </a>
                            </li>

                            <!-- Power Company Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.power.index') }}"
                                    class="nav-link {{ Route::is('admin.power.*') ? 'active' : '' }}"
                                    wire:navigate>
                                    Power Companies
                                </a>
                            </li>

                            <!-- Prize Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.prize.index') }}"
                                    class="nav-link {{ Route::is('admin.prize.*') ? 'active' : '' }}"
                                    wire:navigate>
                                    Prizes
                                </a>
                            </li>

                            <!-- Prize Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.deliverystatus.index') }}"
                                    class="nav-link {{ Route::is('admin.deliverystatus.*') ? 'active' : '' }}"
                                    wire:navigate>
                                    Delivery Status
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <!-- developer and marketer percentage -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.percentage.*') ? 'active' : '' }}"
                        href="#sidebarPercentage"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ Route::is('admin.percentage.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarPercentage">
                        <i class="ri-wallet-line"></i> <span data-key="t-wallet">Percentages</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.percentage.*') ? 'show' : '' }}" id="sidebarPercentage">
                        <ul class="nav nav-sm flex-column">


                            <!-- New Developer Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.percentage.developer.index') }}" class="nav-link {{ Route::is('admin.percentage.developer.*') ? 'active' : '' }}" wire:navigate>Developer Profits</a>
                            </li>

                            <!-- New Marketer Link -->
                            <li class="nav-item">
                                <a href="{{ route('admin.percentage.marketer.index') }}" class="nav-link {{ Route::is('admin.percentage.marketer.*') ? 'active' : '' }}" wire:navigate>Marketer Profits</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.website.*') ? 'active' : '' }}" href="#sidebarWebsite" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarWebsite">
                        <i class="ri-image-line"></i> <span data-key="t-banner">Website</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.website.*') ? 'show' : '' }}" id="sidebarWebsite">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('admin.website.banner.index') }}" class="nav-link {{ Route::is('admin.website.banner.index') ? 'active' : '' }}" wire:navigate>Banners</a></li>

                            <!-- settings -->
                            <li class="nav-item">
                                <a href="{{ route('admin.website.setting.index') }}" class="nav-link {{ Route::is('admin.website.setting.index') ? 'active' : '' }}" wire:navigate>General Settings </a>
                            </li>

                            <!-- faq -->
                            <li class="nav-item">
                                <a href="{{ route('admin.website.faq.index') }}" class="nav-link {{ Route::is('admin.website.faq.index') ? 'active' : '' }}" wire:navigate>FAQs</a>
                            </li>

                            <!-- team -->
                            <li class="nav-item">
                                <a href="{{ route('admin.website.team.index') }}" class="nav-link {{ Route::is('admin.website.team.index') ? 'active' : '' }}" wire:navigate>Team</a>
                            </li>
                        </ul>
                    </div>
                </li>
            

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>