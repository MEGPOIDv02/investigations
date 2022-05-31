<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Investigaciones </title>
    <link rel="icon" type="image/*" href="{{asset('img/admin/login/logo.svg')}}">
    <!-- Style sheets -->
    @include('templates.global_css')
    @stack('styles')
</head>
<body style="background-color: black">
<section >
    @yield('content')
</section>


<!-- Javascript -->
@include('templates.global_js')
</body>
</html>
