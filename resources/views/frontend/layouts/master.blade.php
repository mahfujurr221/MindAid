<!DOCTYPE html>
<html lang="en">

<head>
    <!--================= Meta tag =================-->
    <meta charset="utf-8" />

    <meta name="description" content="" />
    <!--================= Responsive Tag =================-->
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--================= Favicon =================-->
    <link rel="shortcut icon" href="{{ asset('uploads/' . setting()->favicon) }}" type="image/x-icon" />
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--================= style css =================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}" />
    <title>{{ setting()->site_name }} </title>
    @stack('styles')
    
</head>

<body id="page-top" class="course-single">
    @include('frontend.layouts.includes.header')
    
    @yield('content')

    @include('frontend.layouts.includes.footer')


    @include('sweetalert::alert')
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    
    <!-- Template Javascript -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    @stack('scripts')

</body>

</html>