@extends('backend.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Patient Create</h4>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('patients.index') }}" title="Patient List">
                    <i class="bi bi-list"></i> Patient List</a>
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        <div class="mt-3 row card-body">
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
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
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
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" placeholder="Enter age" value="{{ old('age') }}">
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

        <div class="py-3 text-center card-footer">
            <button type="submit" class="btn btn-primary">Create Patient</button>
        </div>
    </form>

</div>

@endsection

@push('scripts')
@endpush