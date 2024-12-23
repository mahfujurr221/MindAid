@extends('frontend.layouts.master')

@section('content')
<div class="py-5 doctors-page">
    <div class="container">
        <h2 class="mb-4 text-center">Meet Our Doctors</h2>

        <!-- Search Bar -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('front.doctor') }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="department" class="form-select">
                                <option value="">Filter by Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="designation" class="form-select">
                                <option value="">Filter by Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ request('designation') == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('front.doctor') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Doctor Cards -->
        <div class="mt-5 row">
            @forelse($doctors as $doctor)
                <div class="mb-4 col-md-3">
                    <div class="card h-100">
                        <div class="doctor-img-container">
                            @if($doctor->image)
                                <img src="{{ asset('backend/assets/images/users/'.$doctor->image) }}" alt="{{ $doctor->fullName() }}" class="card-img-top doctor-img">
                            @else
                                <img src="{{ asset('uploads/user.png') }}" alt="{{ $doctor->fullName() }}" class="card-img-top doctor-img">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->fullName() }}</h5>
                            <p class="card-text"><strong>Department:</strong> {{ $doctor->doctorInfo->department->name ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Designation:</strong> {{ $doctor->doctorInfo->designation->name ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Speciality:</strong> {{ $doctor->doctorInfo->speciality ?? 'N/A' }}</p>
                        </div>
                        <div class="gap-2 card-footer d-flex">
                            <a href="#" class="btn btn-primary btn-sm flex-grow-1">View Profile</a>
                            <a href="#" class="btn btn-success btn-sm flex-grow-1">Book Appointment</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center alert alert-info">No doctors available at the moment.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush
