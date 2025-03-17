@extends('backend.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Patient Edit</h4>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('patients.index') }}" title="Patient List">
                    <i class="bi bi-list"></i> Patient List</a>
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('patients.update', $patient->id) }}">
        @csrf
        @method('PUT')
        <div class="mt-3 row card-body">
            <!-- First Name -->
            <div class="mb-1 col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" placeholder="Enter first name"
                    value="{{ old('fname', $patient->fname) }}">
                @error('fname')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Last Name -->
            <div class="mb-1 col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="Enter last name"
                    value="{{ old('lname', $patient->lname) }}">
                @error('lname')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Email -->
            <div class="mb-1 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email', $patient->email) }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Phone -->
            <div class="mb-1 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number"
                    value="{{ old('phone', $patient->phone) }}">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Gender -->
            <div class="my-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                        {{ old('gender', $patient->patientInfo->gender) == 'male' ? 'checked' : '' }}>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                        {{ old('gender', $patient->patientInfo->gender) == 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" 
                        {{ old('gender', $patient->patientInfo->gender) == 'other' ? 'checked' : '' }}>
                        <label class="form-check-label" for="other">Other</label>
                    </div>
                </div>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Age -->
            <div class="mb-2 col-md-6">
                <label for="age" class="form-label">Age</label>
                    <input type="date" name="age" class="form-control" placeholder="Enter age" value="{{ old('age', $patient->patientInfo->age) }}">
                @error('age')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    
        <div class="py-3 text-center card-footer">
            <button type="submit" class="btn btn-primary">Update Patient</button>
        </div>
    </form>
    
</div>

@endsection

@push('scripts')
@endpush