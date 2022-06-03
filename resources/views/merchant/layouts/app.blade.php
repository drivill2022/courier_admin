<!doctype html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <title>{{ env('app_name', 'Drivill') }} | @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/backend/images/favicon.ico')}}">
    <!-- Bootstrap Css -->
    <link href="{{asset('public/backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('public/backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/backend/css/custom-style.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('public/backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.1/css/line.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
    <style type="text/css">.error{color: red;}</style>

</head>

<body class="authentication-bg">
    <div class="account-pages my-3 pt-sm-5">
       @yield('content')
        <!-- end container -->
    </div>
    <!-- JAVASCRIPT -->
    <script src="{{asset('public/backend/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('public/backend/js/app.js')}}"></script>

</body>

</html>
