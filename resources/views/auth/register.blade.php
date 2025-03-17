@extends('frontend.layouts.master')
@section('content')
<div class="container h-100">
    <form class="form_container" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mt-3 col-md-12">
            <h2 class="text-center">Paitent Registration</h2>
            <hr class="mb-5">

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="mb-1 col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" name="fname" class="form-control" placeholder="Enter first name"
                                value="{{ old('fname') }}">
                            @if ($errors->has('fname'))
                            <span class="text-danger">{{ $errors->first('fname') }}</span>
                            @endif
                        </div>

                        <div class="mb-1 col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Enter last name"
                                value="{{ old('lname') }}">
                            @if ($errors->has('lname'))
                            <span class="text-danger">{{ $errors->first('lname') }}</span>
                            @endif
                        </div>

                        <div class="mb-1 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        
                        <div class="mb-1 col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number"
                                value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>

                        <div class="my-3 col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female"
                                        value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                            @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="age" class="form-label">Date Of Birth</label>
                            <input type="date" name="age" class="form-control" placeholder="Enter age"
                                value="{{ old('age') }}" required>
                            @if ($errors->has('age'))
                            <span class="text-danger">{{ $errors->first('age') }}</span>
                            @endif
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Enter confirm password">
                            @if ($errors->has('confirm_password'))
                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

            <div class="gap-2 py-5 d-grid">
                <button type="submit" class="text-white btn" style="background-color: #01A704">Register</button>
            </div>

        </div>
    </form>
</div>
@endsection


@push('scripts')
@endpush