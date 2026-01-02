<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Jonopriyo Bazar</title>
    <link rel="icon" href="{{ asset('backend/favicon.png') }}" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/dist/summernote.css') }}"/>

    <!-- Dropify -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropify/css/dropify.min.css') }}">

    <!-- Bootstrap Datatable -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">

    <!-- Bootstrap Tagsinput Css -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />


    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert/sweetalert.css') }}"/>

    <!-- bootstrap toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">

</head>

<body class="theme-blush">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ url('backend/images/loader.svg') }}" width="48" height="48" alt="Aero"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Main Search -->
    <div id="search">
        <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
        <form>
          <input type="search" value="" placeholder="Search..." />
          <button type="submit" class="btn btn-primary">Search</button>
      </form>
  </div>

  <!-- Right Icon menu Sidebar -->
  <div class="navbar-right">
    <ul class="navbar-nav">
        <li><a href="#search" class="main_search" title="Search..."><i class="zmdi zmdi-search"></i></a></li>
        
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="Notifications" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                @if(Auth::user()->unreadNotifications->count()>0)
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                @endif
            </a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">Notifications</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        @foreach(Auth::user()->unreadNotifications as $notification)
                        <li>
                            <a href="{{ route('admin.notification.show', $notification->id) }}">
                                <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                <div class="menu-info">
                                    <h4>{{ $notification->data['data']['name']}} - {{ $notification->data['info'] }}</h4>
                                    <p><i class="zmdi zmdi-time"></i> {{ date('j F, Y', strtotime($notification->created_at)) }} at {{ date('h:m a', strtotime($notification->created_at)) }} </p>
                                </div>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </li>
                <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
            </ul>
        </li>


        <li><a href="javascript:void(0);" class="js-right-sidebar" title="Setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
        <li>
            <a href="{{ route('admin.logout.submit')}}" onclick="event.preventDefault();
            document.getElementById('admin-logout-form').submit();" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a>


            <form id="admin-logout-form" action="{{ route('admin.logout.submit')}}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="{{ url('backend/images/logo.png') }}" width="25" alt="Aero"><span class="m-l-10">Jonopriyo Bazar</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="{{ url('backend/images/profile_av.jpg') }}" alt="User"></a>
                    <div class="detail">
                        <h4>Admin</h4>

                        <small>Admin</small>
                        
                    </div>
                </div>
            </li>
            <li class="{{ Route::is('admin.dashboard') ? 'active open' : '' }}">
                <a href="{{ route('admin.dashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>
            <li><a href="my-profile.html"><i class="zmdi zmdi-account"></i><span>My Profile</span></a></li>

            @can('admin.permissions.index')
            <li class="{{ Route::is('admin.permissions.*') ? 'active open' : '' }}">
                <a href="{{ route('admin.permissions.index')}}"><i class="zmdi zmdi-account"></i><span>Permissions</span>
                </a>
            </li>
            @endcan

            @if(Auth::user()->can('admin.roles.index') || Auth::user()->can('admin.roles.create'))
            <li class="{{ Route::is('admin.roles.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-box-o"></i><span>Roles</span></a>
                <ul class="ml-menu">
                    @can('admin.roles.index')
                    <li class="{{ Route::is('admin.roles.index') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                    @endcan
                    @can('admin.roles.create')
                    <li class="{{ Route::is('admin.roles.create') ? 'active' : '' }}"><a href="{{ route('admin.roles.create')}}">Add New</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('admin.admins.index') || Auth::user()->can('admin.admins.create'))
            <li class="{{ Route::is('admin.admins.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-alt"></i><span>Admins</span></a>
                <ul class="ml-menu">
                    @can('admin.admins.index')
                    <li class="{{ Route::is('admin.admins.index') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                    @endcan
                    @can('admin.admins.create')
                    <li class="{{ Route::is('admin.admins.create') ? 'active' : '' }}"><a href="{{ route('admin.admins.create')}}">Add New</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @can('category')
            <li class="{{ Route::is('admin.category.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-toys"></i><span>Category</span></a>
                <ul class="ml-menu">

                    <li class="{{ Route::is('admin.category.index') ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}">All Categories</a></li>
                    
                    <li class="{{ Route::is('admin.category.create') ? 'active' : '' }}"><a href="{{ route('admin.category.create')}}">Add New</a></li>
                    
                </ul>
            </li>
            @endcan

            @can('products')
            <li class="{{ Route::is('admin.products.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-basket"></i><span>Products</span></a>
                <ul class="ml-menu">

                    <li class="{{ Route::is('admin.products.index') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}">All Products</a></li>
                    
                    <li class="{{ Route::is('admin.products.create') ? 'active' : '' }}"><a href="{{ route('admin.products.create')}}">Add New</a></li>
                    
                </ul>
            </li>
            @endcan
            
            @can('cupon')
            <li class="{{ Route::is('admin.cupon.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.cupon.index')}}"><i class="zmdi zmdi-label"></i><span>Cupon</span>
                </a>
            </li>
            @endcan
            
            @can('address')
            <li class="{{ Route::is('admin.district.index') || Route::is('admin.thana.index') || Route::is('admin.city.index') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-library"></i><span>Address</span></a>
                <ul class="ml-menu">

                    <li class="{{ Route::is('admin.district.index') ? 'active' : '' }}"><a href="{{ route('admin.district.index') }}">District</a></li>

                    <li class="{{ Route::is('admin.thana.index') ? 'active' : '' }}"><a href="{{ route('admin.thana.index') }}">Thana</a></li>

                    <li class="{{ Route::is('admin.city.index') ? 'active' : '' }}"><a href="{{ route('admin.city.index') }}">City/Area</a></li>
                    
                </ul>
            </li>
            @endcan


            @can('banner')
            <li class="{{ Route::is('admin.banner.index') || Route::is('admin.banner.create')  ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-image"></i><span>Banner</span></a>
                <ul class="ml-menu">              
                    <li class="{{ Route::is('admin.banner.index') ? 'active' : '' }}"><a href="{{ route('admin.banner.index') }}">List</a></li>
                    <li class="{{ Route::is('admin.banner.create') ? 'active' : '' }}"><a href="{{ route('admin.banner.create') }}">Create</a></li>
                </ul>
            </li>
            @endcan


            @can('wallet')
            <li class="{{ Route::is('admin.walletpackage.index') || Route::is('admin.walletuser.index') || Route::is('admin.walletrequest.index') || Route::is('admin.packageapplication.index') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-balance-wallet"></i><span>Wallet</span></a>
                <ul class="ml-menu">              
                    <li class="{{ Route::is('admin.walletpackage.index') ? 'active' : '' }}"><a href="{{ route('admin.walletpackage.index') }}">Package</a></li>

                    <li class="{{ Route::is('admin.walletuser.index') ? 'active' : '' }}"><a href="{{ route('admin.walletuser.index') }}">User</a></li>

                    <li class="{{ Route::is('admin.walletrequest.index') ? 'active' : '' }}"><a href="{{ route('admin.walletrequest.index') }}">Requests</a></li>

                    <li class="{{ Route::is('admin.packageapplication.index') ? 'active' : '' }}"><a href="{{ route('admin.packageapplication.index') }}">Package Applications</a></li>
                </ul>
            </li>
            @endcan


            @can('customer')
            <li class="{{ Route::is('admin.customer.index') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-alt"></i><span>Customer</span></a>
                <ul class="ml-menu">              
                    <li class="{{ Route::is('admin.customer.index') ? 'active' : '' }}"><a href="{{ route('admin.customer.index') }}">List</a></li>
                    
                </ul>
            </li>
            @endcan

        
            @can('orders')
            <li class="{{ Route::is('admin.order.*') || Route::is('admin.customorder.*') || Route::is('admin.medicine.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-store"></i><span>Orders</span></a>
                <ul class="ml-menu">
                    
                    <li class="{{ Route::is('admin.order.index') ? 'active' : '' }}"><a href="{{ route('admin.order.index') }}">Product Order</a></li>
                    
                    <li class="{{ Route::is('admin.customorder.index') ? 'active' : '' }}"><a href="{{ route('admin.customorder.index')}}">Custom Order</a></li>

                    <li class="{{ Route::is('admin.medicine.index') ? 'active' : '' }}"><a href="{{ route('admin.medicine.index')}}">Medicine Order</a></li>

                    <li class="{{ Route::is('admin.electricity.index') ? 'active' : '' }}"><a href="{{ route('admin.electricity.index')}}">Electricity Bill</a></li>
                    
                </ul>
            </li>
            @endcan
            
            
            @can('others')
            <li class="{{ Route::is('admin.deliverystatus.*') || Route::is('admin.power.*') || Route::is('admin.reason.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-puzzle-piece"></i><span>Others</span></a>
                <ul class="ml-menu">
                    
                    <li class="{{ Route::is('admin.deliverystatus.index') ? 'active' : '' }}"><a href="{{ route('admin.deliverystatus.index') }}">Delivery Status</a></li>
                    
                    <li class="{{ Route::is('admin.power.index') ? 'active' : '' }}"><a href="{{ route('admin.power.index')}}">Power Company</a></li>

                    <li class="{{ Route::is('admin.reason.index') ? 'active' : '' }}"><a href="{{ route('admin.reason.index')}}">Cancel Reason</a></li>
                    
                </ul>
            </li>
            @endcan

            @can('percentage')
            <li class="{{ Route::is('admin.developer.index') || Route::is('admin.marketer.index') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-puzzle-piece"></i><span>Percentage</span></a>
                <ul class="ml-menu">
                    <li class="{{ Route::is('admin.developer.index') ? 'active' : '' }}"><a href="{{ route('admin.developer.index') }}">Developer</a></li>

                    <li class="{{ Route::is('admin.marketer.index') ? 'active' : '' }}"><a href="{{ route('admin.marketer.index') }}">Maketer</a></li> 
                </ul>
            </li>
            @endcan


            @can('report')
            <li class="{{ Route::is('sale.report.index') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-puzzle-piece"></i><span>Report</span></a>
                <ul class="ml-menu">
                    <li class="{{ Route::is('sale.report.index') ? 'active' : '' }}"><a href="{{ route('sale.report.index') }}">Sale Report</a></li>
                </ul>
            </li>
            @endcan


            @can('prize')
            <li class="{{ Route::is('admin.prize.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.prize.index')}}"><i class="zmdi zmdi-settings"></i><span>Prize</span>
                </a>
            </li>
            @endcan

            <li class="{{ Route::is('admin.userprize.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.userprize.index')}}"><i class="zmdi zmdi-settings"></i><span>User Prize</span>
                </a>
            </li>

            <li class="{{ Route::is('admin.withdraw.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.withdraw.index')}}"><i class="zmdi zmdi-settings"></i><span>User Withdraw</span>
                </a>
            </li>

            <li class="{{ Route::is('admin.faq.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.faq.index')}}"><i class="zmdi zmdi-settings"></i><span>Faq</span>
                </a>
            </li>

            <li class="{{ Route::is('admin.team.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-puzzle-piece"></i><span>Team Member</span></a>
                <ul class="ml-menu">
                    <li class="{{ Route::is('admin.team.index') ? 'active' : '' }}"><a href="{{ route('admin.team.index') }}">Member List</a></li>

                    <li class="{{ Route::is('admin.team.create') ? 'active' : '' }}"><a href="{{ route('admin.team.create') }}">Add Member</a></li> 
                </ul>
            </li>

            @can('setting')
            <li class="{{ Route::is('admin.setting.index') ? 'active open' : '' }}">
                <a href="{{ route('admin.setting.index')}}"><i class="zmdi zmdi-settings"></i><span>Setting</span>
                </a>
            </li>
            @endcan


        </ul>
    </div>
</aside>


<!-- Main Content -->

<section class="content {{ Route::is('admin.gallery.index') ? 'file_manager' : '' }}">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>@yield('title')</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                @yield('button')
            </div>
        </div>
    </div>
    @yield('content')
</section>


<!-- Jquery Core Js -->
<script src="{{ asset('backend/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
<script src="{{ asset('backend/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- bootstrap toogle -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

@yield('scripts')

<script src="{{ asset('backend/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js -->

<script>
    // ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    @if(Session::has('success'))
    swal({
        title: "Good job!",
        text: "{{ Session::get('success')}}",
        icon: "success",
    });
    @endif
</script>

</body>
</html>
