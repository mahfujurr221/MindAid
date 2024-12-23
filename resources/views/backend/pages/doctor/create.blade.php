@extends('backend.layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Doctor Create</h4>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('doctors.index') }}" title="Doctor List">
                    <i class="bi bi-list"></i> Doctor List
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('doctors.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mt-3 row card-body">

            <!-- First Name -->
            <div class="mb-1 col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" placeholder="Enter first name"
                    value="{{ old('fname') }}">
                @error('fname')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-1 col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="Enter last name"
                    value="{{ old('lname') }}">
                @error('lname')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-1 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email') }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-1 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number"
                    value="{{ old('phone') }}">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Department -->
            <div class="mb-1 col-md-6">
                <label for="department_id" class="form-label">Department</label>
                <select name="department_id" class="form-control">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id')==$department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                    @endforeach
                </select>
                @error('department_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Designation -->
            <div class="mb-1 col-md-6">
                <label for="designation_id" class="form-label">Designation</label>
                <select name="designation_id" class="form-control">
                    <option value="">Select Designation</option>
                    @foreach ($designations as $designation)
                    <option value="{{ $designation->id }}" {{ old('designation_id')==$designation->id ? 'selected' : ''
                        }}>
                        {{ $designation->name }}
                    </option>
                    @endforeach
                </select>
                @error('designation_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Speciality -->
            <div class="mb-1 col-md-6">
                <label for="speciality" class="form-label">Speciality</label>
                <input type="text" name="speciality" class="form-control" placeholder="Enter speciality"
                    value="{{ old('speciality') }}">
                @error('speciality')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fee -->
            <div class="mb-1 col-md-6">
                <label for="fee" class="form-label">Consultation Fee</label>
                <input type="number" name="fee" class="form-control" placeholder="Enter fee" value="{{ old('fee') }}"
                    min="0" step="0.01">
                @error('fee')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-2 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password">
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-2 col-md-6">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control"
                    placeholder="Enter confirm password">
                @error('confirm_password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload Section -->
            <div class="mb-2 col-md-6">
                <label for="profileImage" class="form-label">Profile Image</label>
                <div class="col-md-4 col-lg-4">
                    <img id="profileImagePreview" src="{{ asset('uploads/user.png') }}" alt="Profile"
                        class="img-thumbnail" width="150" height="150">

                    <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm"
                            onclick="document.getElementById('profileImageUpload').click();"
                            title="Upload new profile image">
                            <i class="bi bi-upload"></i>
                        </a>
                        <input type="file" id="profileImageUpload" name="image" style="display: none;" accept="image/*"
                            onchange="previewProfileImage(event)" />
                        <a href="#" class="btn btn-danger btn-sm" title="Remove profile image"
                            onclick="removeProfileImage();"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="py-3 text-center card-footer">
            <button type="submit" class="btn btn-primary">Create Doctor</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
function previewProfileImage(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const preview = document.getElementById('profileImagePreview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        reader.readAsDataURL(file); 
    }
}

function removeProfileImage() {
    const fileInput = document.getElementById('profileImageUpload');
    const preview = document.getElementById('profileImagePreview');

    // Clear file input and reset image preview
    fileInput.value = '';
    preview.src = '{{ asset('uploads/user.png') }}';
}
</script>
@endpush
