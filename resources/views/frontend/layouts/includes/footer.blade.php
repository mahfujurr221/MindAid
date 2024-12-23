<!-- Footer Start -->
<div class="py-5 mt-5 container-fluid bg-dark text-light">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary">Get
                    In Touch</h4>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor
                </p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>{{ setting()->address??'' }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>{{ setting()->email??'' }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary me-3"></i>{{ setting()->phone??'' }}</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary">
                    Quick Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="mb-2 text-light" href="#"><i class="fa fa-angle-right me-2"></i>Home</a>
                    <a class="mb-2 text-light" href="#"><i class="fa fa-angle-right me-2"></i>About Us</a>
                    <a class="text-light" href="#"><i class="fa fa-angle-right me-2"></i>Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary">
                    Popular Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="mb-2 text-light" href="#"><i class="fa fa-angle-right me-2"></i>Home</a>
                    <a class="mb-2 text-light" href="#"><i class="fa fa-angle-right me-2"></i>About Us</a>
                    <a class="text-light" href="#"><i class="fa fa-angle-right me-2"></i>Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary">
                    Newsletter</h4>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="p-3 border-0 form-control" placeholder="Your Email Address">
                        <button class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
                <h6 class="mt-4 mb-3 text-primary text-uppercase">Follow Us</h6>
                <div class="d-flex">
                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2"
                        href="{{ setting()->twitter??'' }}">
                        <i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2"
                        href="{{ setting()->facebook??'' }}">
                        <i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2"
                        href="{{ setting()->linkedin??'' }}">
                        <i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle"
                        href="{{ setting()->instagram??'' }}">
                        <i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-4 container-fluid bg-dark text-light border-top border-secondary">
    <div class="container">
        <div class="row g-5">
            <div class="text-center col-md-6 text-md-start">
                <p class="mb-md-0">&copy; <a class="text-primary" href="{{route('website')}}">
                    E-Healthcare</a>.All Rights Reserved.</p>
            </div>
            <div class="text-center col-md-6 text-md-end">
                <p class="mb-0">Developed By <a class="text-primary" href="{{route('website')}}">E-Healthcare</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->