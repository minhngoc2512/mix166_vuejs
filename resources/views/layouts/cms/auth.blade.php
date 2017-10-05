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
    <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
    <meta name="author" content="Lukasz Holeczek">
    <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>CoreUI Bootstrap 4 Admin Template</title>

    <!-- Icons -->
    <link href="{!! asset('node_modules/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('node_modules/simple-line-icons/css/simple-line-icons.css') !!}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">


@yield('content')
<script>
    window.cms ={
        "csrfToken": "{{csrf_token()}}"
    }

</script>

<!-- Bootstrap and necessary plugins -->
<script src="{!! asset('node_modules/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('node_modules/popper.js/dist/umd/popper.min.js') !!}"></script>
<script src="{!! asset('node_modules/bootstrap/dist/js/bootstrap.min.js') !!}"></script>

</body>

</html>