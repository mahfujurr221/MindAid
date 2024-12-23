@extends('frontend.layouts.master')

@section('content')
<div class="py-5 contact-page">
    <div class="container">
        <h2 class="mb-4 text-center">Contact Us</h2>
        <div class="row">
            <!-- Left Column: Contact Details -->
            <div class="mb-4 col-md-5">
                <div class="p-4 rounded shadow bg-light">
                    <h4>Get in Touch</h4>
                    <p><strong>Address:</strong> {{ setting()->address??'' }}</p>
                    <p><strong>Phone:</strong> <a href="tel:{{ setting()->phone??'' }}">{{ setting()->phone??'' }}</a></p>
                    <p><strong>Email:</strong> <a href="mailto:{{ setting()->email??'' }}">{{ setting()->email??'' }}</a></p>
                    <p><strong>Working Hours:</strong> 24 Hours</p>
                </div>
            </div>

            <!-- Right Column: Contact Form -->
            <div class="col-md-7">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="#" method="POST" class="p-4 rounded shadow bg-light">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject"
                            class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" rows="5"
                            class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
