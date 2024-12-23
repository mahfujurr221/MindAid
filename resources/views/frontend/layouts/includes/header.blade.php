<!-- Topbar Start -->
<div class="py-2 container-fluid border-bottom d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="mb-2 text-center col-md-6 text-lg-start mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <a class="text-decoration-none text-body pe-3" href=""><i class="bi bi-telephone me-2"></i>{{
                        setting()->phone??'' }}</a>
                    <span class="text-body">|</span>
                    <a class="px-3 text-decoration-none text-body" href=""><i class="bi bi-envelope me-2"></i>{{
                        setting()->email??'' }}</a>
                </div>
            </div>
            <div class="text-center col-md-6 text-lg-end">
                <div class="d-inline-flex align-items-center">
                    <a class="px-2 text-body" target="_blank" href="{{ setting()->facebook??'' }}">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="px-2 text-body" target="_blank" href="{{ setting()->twitter??'' }}">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="px-2 text-body" target="_blank" href="{{ setting()->linkedin??'' }}">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="px-2 text-body" target="_blank" href="{{ setting()->instagram??'' }}">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-body ps-2" target="_blank" href="{{ setting()->youtube??'' }}">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="bg-white shadow-sm container-fluid sticky-top">
    <div class="container">
        <nav class="py-3 bg-white navbar navbar-expand-lg navbar-light py-lg-0">
            <a href="{{ route('website') }}" class="navbar-brand">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>E-Healthcare</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="py-0 navbar-nav ms-auto">
                    <a href="{{ url('/') }}" 
                       class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                       <a href="#" 
                       class="nav-item nav-link">Appointments</a>
                       <a href="{{ route('front.doctor') }}"
                       class="nav-item nav-link {{ request()->routeIs('front.doctor') ? 'active' : '' }}">Doctors</a>
                       <a href="{{ route('front.about') }}" 
                          class="nav-item nav-link {{ request()->routeIs('front.about') ? 'active' : '' }}">About</a>
                    <a href="{{ route('front.contact') }}"
                       class="nav-item nav-link {{ request()->routeIs('front.contact') ? 'active' : '' }}">Contact</a>
            
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}" target="_blank" 
                           class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" target="_blank" 
                           class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" target="_blank" 
                           class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                    @endif
                </div>
            </div>
            
        </nav>
    </div>
</div>
<!-- Navbar End -->