<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword"
          content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,Angular 2,Angular4,Angular 4,jQuery,CSS,HTML,RWD,Dashboard,React,React.js,Vue,Vue.js">
    <link rel="shortcut icon" href="{!! asset("img/favicon.png") !!}">
    <title>CoreUI - Open Source Bootstrap Admin Template</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link href="{!! asset('node_modules/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('node_modules/simple-line-icons/css/simple-line-icons.css') !!}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet">
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'			- Fixed Breadcrumb

// Footer options
1. '.footer-fixed'					- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">☰</button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Users</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Settings</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-bell"></i><span
                        class="badge badge-pill badge-danger">5</span></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-list"></i></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                <img src="{!! asset('img/avatars/6.jpg') !!}" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="d-md-down-none">
                    @if(Auth::check())
                        {!! Auth::user()->name !!}
                        @else
                        Login
                    @endif

                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-bell-o"></i> Updates<span
                            class="badge badge-info">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i> Messages<span
                            class="badge badge-success">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-tasks"></i> Tasks<span
                            class="badge badge-danger">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-comments"></i> Comments<span
                             class="badge badge-warning">42</span></a>
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> Settings</a>
                <a class="dropdown-item" href="#"><i class="fa fa-usd"></i> Payments<span class="badge badge-secondary">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-file"></i> Projects<span class="badge badge-primary">42</span></a>
                <div class="divider"></div>
                <a class="dropdown-item" href="#"><i class="fa fa-shield"></i> Lock Account</a>
                <a class="dropdown-item" href="{{route('logout')}}"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler" type="button">☰</button>

</header>
<div class="app-body">
    @include('layouts.cms.sidebar')
    @yield('content')

</div>
<footer class="app-footer">
    <a href="http://coreui.io">CoreUI</a> © 2017 creativeLabs.
    <span class="float-right">Powered by <a href="http://coreui.io">CoreUI</a>
        </span>
</footer>

<!-- Bootstrap and necessary plugins -->
<script src="{!! asset('node_modules/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('node_modules/popper.js/dist/umd/popper.min.js') !!}"></script>
<script src="{!! asset('node_modules/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('node_modules/pace-progress/pace.min.js') !!}"></script>


<!-- Plugins and scripts required by all views -->
{{--<script src="{!! asset('node_modules/chart.js/dist/Chart.min.js') !!}"></script>--}}


<!-- GenesisUI main scripts -->

<script src="{!! asset('js/app_core.js') !!}"></script>
<script>
    window.cms ={
        "csrfToken": "{{csrf_token()}}",
        "auth":'["{{Auth::user()->id}}","{{Auth::user()->name}}"]'
    }

</script>

<!-- Plugins and scripts required by this views -->

<!-- Custom scripts required by this view -->
{{--<script src="{!! asset('js/views/main.js') !!}"></script>--}}
@stack('scripts')

</body>

</html>


