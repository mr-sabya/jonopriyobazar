<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title> @yield('title') - Jonopriyo Bazar</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('backend/favicon.png') }}" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.min.css') }}">    
</head>

<body class="theme-blush">

    @yield('content')

    <!-- Jquery Core Js -->
    <script src="{{ asset('backend/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('backend/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->
</body>
</html>