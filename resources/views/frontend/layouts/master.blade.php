<!DOCTYPE html>
<html lang="en">

<head>
    <!--================= Meta tag =================-->
    <meta charset="utf-8" />

    <meta name="description" content="" />
    <!--================= Responsive Tag =================-->
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mind-Aid</title>
    <!--================= Favicon =================-->
		<!-- Favicons -->
		<link type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" >

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    @stack('styles')

</head>

<body id="page-top" class="course-single">
    @include('frontend.layouts.includes.header')

    @yield('content')

    @include('frontend.layouts.includes.footer')


    @include('sweetalert::alert')

    <!-- JavaScript Libraries -->

    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/popper.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('frontend/js/slick.js')}}"></script>
    <script src="{{asset('frontend/js/script.js')}}"></script>

    @stack('scripts')

</body>

</html>
