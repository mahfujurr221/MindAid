@extends('frontend.layouts.master')
@section('content')
<!-- Hero Start -->
<div class="py-5 mb-5 container-fluid bg-primary hero-header">
    <div class="container py-5">
        <div class="row justify-content-start">
            <div class="text-center col-lg-8 text-lg-start">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5"
                    style="border-color: rgba(256, 256, 256, .3) !important;">Welcome To Medinova</h5>
                <h1 class="text-white display-1 mb-md-4">Best Healthcare Solution In Your City</h1>
                <div class="pt-2">
                    <a href="" class="mx-2 btn btn-light rounded-pill py-md-3 px-md-5">Find Doctor</a>
                    <a href="" class="mx-2 btn btn-outline-light rounded-pill py-md-3 px-md-5">Appointment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->


<!-- About Start -->
<div class="py-5 container-fluid">
    <div class="container">
        <div class="row gx-5">
            <div class="mb-5 col-lg-5 mb-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="rounded position-absolute w-100 h-100" src="{{asset('frontend')}}/img/about.jpg"
                        style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-4">
                    <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">About Us</h5>
                    <h1 class="display-4">{{$aboutUs->title??''}}</h1>
                </div>

                <p>{{$aboutUs->description??''}}</p>

                <div class="pt-3 row g-3">
                    <div class="col-sm-3 col-6">
                        <div class="py-4 text-center bg-light rounded-circle">
                            <i class="mb-3 fa fa-3x fa-user-md text-primary"></i>
                            <h6 class="mb-0">Qualified<small class="d-block text-primary">Doctors</small></h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="py-4 text-center bg-light rounded-circle">
                            <i class="mb-3 fa fa-3x fa-procedures text-primary"></i>
                            <h6 class="mb-0">Emergency<small class="d-block text-primary">Services</small></h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="py-4 text-center bg-light rounded-circle">
                            <i class="mb-3 fa fa-3x fa-microscope text-primary"></i>
                            <h6 class="mb-0">Accurate<small class="d-block text-primary">Testing</small></h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="py-4 text-center bg-light rounded-circle">
                            <i class="mb-3 fa fa-3x fa-ambulance text-primary"></i>
                            <h6 class="mb-0">Free<small class="d-block text-primary">Ambulance</small></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Services Start -->
<div class="py-5 container-fluid">
    <div class="container">
        <div class="mx-auto mb-5 text-center" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Services</h5>
            <h1 class="display-4">Excellent Medical Services</h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-user-md"></i>
                    </div>
                    <h4 class="mb-3">Emergency Care</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-procedures"></i>
                    </div>
                    <h4 class="mb-3">Operation & Surgery</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-stethoscope"></i>
                    </div>
                    <h4 class="mb-3">Outdoor Checkup</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-ambulance"></i>
                    </div>
                    <h4 class="mb-3">Ambulance Service</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-pills"></i>
                    </div>
                    <h4 class="mb-3">Medicine & Pharmacy</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="text-center rounded service-item bg-light d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 service-icon">
                        <i class="text-white fa fa-2x fa-microscope"></i>
                    </div>
                    <h4 class="mb-3">Blood Testing</h4>
                    <p class="m-0">Kasd dolor no lorem nonumy sit labore tempor at justo rebum rebum stet, justo elitr
                        dolor amet sit</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->


<!-- Appointment Start -->
<div class="py-5 my-5 container-fluid bg-primary">
    <div class="container py-5">
        <div class="row gx-5">
            <div class="mb-5 col-lg-6 mb-lg-0">
                <div class="mb-4">
                    <h5 class="text-white d-inline-block text-uppercase border-bottom border-5">Appointment</h5>
                    <h1 class="display-4">Make An Appointment For Your Family</h1>
                </div>
                <p class="mb-5 text-white">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd ipsum. Dolor
                    ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt voluptua. Eos vero eos vero
                    ea et dolore eirmod et. Dolores diam duo invidunt lorem.
                    Elitr ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.</p>
                <a class="px-5 py-3 btn btn-dark rounded-pill me-3" href="">Find Doctor</a>
                <a class="px-5 py-3 btn btn-outline-dark rounded-pill" href="">Read More</a>
            </div>
            <div class="col-lg-6">
                <div class="p-5 text-center bg-white rounded">
                    <h1 class="mb-4">Book An Appointment</h1>
                    <form>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <select class="border-0 form-select bg-light" style="height: 55px;">
                                    <option selected>Choose Department</option>
                                    <option value="1">Department 1</option>
                                    <option value="2">Department 2</option>
                                    <option value="3">Department 3</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <select class="border-0 form-select bg-light" style="height: 55px;">
                                    <option selected>Select Doctor</option>
                                    <option value="1">Doctor 1</option>
                                    <option value="2">Doctor 2</option>
                                    <option value="3">Doctor 3</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="border-0 form-control bg-light" placeholder="Your Name"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" class="border-0 form-control bg-light" placeholder="Your Email"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="date" id="date" data-target-input="nearest">
                                    <input type="text" class="border-0 form-control bg-light datetimepicker-input"
                                        placeholder="Date" data-target="#date" data-toggle="datetimepicker"
                                        style="height: 55px;">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="time" id="time" data-target-input="nearest">
                                    <input type="text" class="border-0 form-control bg-light datetimepicker-input"
                                        placeholder="Time" data-target="#time" data-toggle="datetimepicker"
                                        style="height: 55px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="py-3 btn btn-primary w-100" type="submit">Make An Appointment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->


<!-- Team Start -->
<div class="py-5 container-fluid">
    <div class="container">
        <div class="mx-auto mb-5 text-center" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Our Doctors</h5>
            <h1 class="display-4">Qualified Healthcare Professionals</h1>
        </div>
        @foreach($doctors as $doctor)
        <div class="owl-carousel team-carousel position-relative">
            <div class="team-item">
                <div class="overflow-hidden rounded row g-0 bg-light">
                    <div class="col-12 col-sm-5 h-100">
                        <img class="img-fluid h-100" src="{{asset('backend/assets/images/users/'.$doctor->image)}}"
                            style="object-fit: cover;">
                    </div>
                    <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                        <div class="p-4 mt-auto">
                            <h3>{{$doctor->fullName()}}</h3>
                            <p class="m-0">
                                {{$doctor->doctorInfo->department->name??''}}
                            </p>
                            <h6 class="mb-4 fw-normal fst-italic text-primary">{{$doctor->doctorInfo->designation->name??''}}</h6>
                            <p class="m-0">
                                {{$doctor->doctorInfo->speciality??''}}
                            </p>
                        </div>
                        <div class="p-4 mt-auto d-flex border-top">
                            <a class="btn btn-primary me-3" href="#">View Profile</a>
                            <a class="btn btn-outline-primary" href="#">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Team End -->


<!-- Testimonial Start -->
<div class="py-5 container-fluid">
    <div class="container">
        <div class="mx-auto mb-5 text-center" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Testimonial</h5>
            <h1 class="display-4">Patients Say About Our Services</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="owl-carousel testimonial-carousel">
                    <div class="text-center testimonial-item">
                        <div class="mb-5 position-relative">
                            <img class="mx-auto img-fluid rounded-circle"
                                src="{{asset('frontend')}}/img/testimonial-1.jpg" alt="">
                            <div class="bg-white position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-normal">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore
                            dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.
                            Erat dolor rebum sit ipsum.</p>
                        <hr class="mx-auto w-25">
                        <h3>Patient Name</h3>
                        <h6 class="mb-3 fw-normal text-primary">Profession</h6>
                    </div>
                    <div class="text-center testimonial-item">
                        <div class="mb-5 position-relative">
                            <img class="mx-auto img-fluid rounded-circle"
                                src="{{asset('frontend')}}/img/testimonial-2.jpg" alt="">
                            <div class="bg-white position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-normal">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore
                            dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.
                            Erat dolor rebum sit ipsum.</p>
                        <hr class="mx-auto w-25">
                        <h3>Patient Name</h3>
                        <h6 class="mb-3 fw-normal text-primary">Profession</h6>
                    </div>
                    <div class="text-center testimonial-item">
                        <div class="mb-5 position-relative">
                            <img class="mx-auto img-fluid rounded-circle"
                                src="{{asset('frontend')}}/img/testimonial-3.jpg" alt="">
                            <div class="bg-white position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4 fw-normal">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore
                            dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.
                            Erat dolor rebum sit ipsum.</p>
                        <hr class="mx-auto w-25">
                        <h3>Patient Name</h3>
                        <h6 class="mb-3 fw-normal text-primary">Profession</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->


<!-- Blog End -->
@endsection