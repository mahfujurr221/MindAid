@extends('backend.layouts.master')
@section('content')

@if(!auth()->user()->hasRole('Patient'))
<div class="card">
    <div class="card-body">
        <form>
            <div class="mt-4 row">
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Search by Appointment Id" name="appointment_id"
                           value="{{ request()->appointment_id }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Search by Appointment Note" name="note"
                           value="{{ request()->note }}">
                </div>
        
                @if(auth()->user()->hasRole('Super Admin'))
                <div class="col-md-2">
                    <select class="form-select" name="doctor_id">
                        <option value="">Select Doctor</option>
                        @foreach(\App\Models\User::where('type', 'doctor')->get() as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->fname }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
        
                <div class="col-md-2">
                    <select class="form-select" name="patient_id">
                        <option value="">Select Patient</option>
                        @foreach(\App\Models\User::where('type', 'patient')->get() as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->fname }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="" disabled selected>Select Status</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Started</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Ended</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
        
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
        
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Appointment List</h4>
            </div>
            @if(!auth()->user()->hasRole('Patient'))
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('appointments.create') }}">
                    <i class="bi bi-plus"></i> Add New Appointment
                </a>
            </div>
            @endif

        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Note</th>
                    <th>Comment</th>
                    @if(auth()->user()->hasRole('Patient'))
                    <th>Join Meeting</th>
                    @else
                    <th>Start Meeting</th>
                    @endif
                    <th>Copy URL</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $key => $data)
                <tr class="text-center">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->doctor->fullName() }}</td>
                    <td>{{ $data->patient->fullName() }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->appoinment_date)->format('D, d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->appoinment_date)->format('H:i A') }}</td>
                    <td>{{ $data->appoinment_note }}</td>
                    <td>{{ Str::limit($data->comment, 20) }}</td>

                    <td>
                        <form action="{{ route('appointments.update-status', $data->id) }}" method="POST">
                            @csrf
                            @if($data->status == 2)
                            <button class="btn btn-secondary btn-sm disabled" title="Meeting Ended">
                                <i class="bi bi-camera-video"></i> Meeting Ended
                            </button>
                            @elseif($data->status == 0)
                            <button class="btn btn-secondary btn-sm disabled" title="Meeting Not Started">
                                <i class="bi bi-camera-video"></i> Pending
                            </button>
                            @elseif($data->status == 3)
                            <span class="badge bg-danger">Canceled</span>
                            @else
                            @if(auth()->user()->hasRole('Patient'))
                            <a href="{{ $data->join_url }}" target="_blank" class="btn btn-primary btn-sm"
                                title="Join Meeting">
                                <i class="bi bi-camera-video"></i> Join Meeting
                            </a>

                            <button class="btn btn-outline-primary btn-sm" {{ $data->status == 3 ? 'disabled' : '' }}
                                onclick="copyLink('{{ auth()->user()->hasRole('Patient') ? $data->join_url :
                                $data->start_url }}', '{{ $data->id }}')">
                                <i class="bi bi-link"></i> Copy Link
                            </button>
                            <span id="copy-msg-{{ $data->id }}" class="text-success ms-2"
                                style="display: none;">Copied!</span>

                            @else
                            <a href="{{ $data->start_url }}" target="_blank" class="btn btn-primary btn-sm"
                                title="Start Meeting">
                                <i class="bi bi-camera-video"></i> Start Meeting
                                <input type="hidden" name="status" value="started">
                            </a>
                            @endif
                            @endif
                        </form>
                    </td>

                    <td>
                        <button 
                            class="btn btn-outline-primary btn-sm" 
                            {{ $data->status == 3 ? 'disabled' : '' }} 
                            onclick="copyLink('{{ auth()->user()->hasRole('Patient') ? $data->join_url : $data->start_url }}', '{{ $data->id }}')">
                            <i class="bi bi-link"></i> Copy Link
                        </button>   
                        <span id="copy-msg-{{ $data->id }}" class="text-success ms-2" style="display: none;">Copied!</span>
                    </td>

                    {{-- Display meeting status --}}
                    @if(auth()->user()->hasRole('Patient'))
                    <td>
                        @if($data->status == 0)
                        <span class="badge bg-warning">Pending</span>
                        @elseif($data->status == 1)
                        <span class="badge bg-success">Started</span>
                        @elseif($data->status == 3)
                        <span class="badge bg-danger">Cancelled</span>
                        @else
                        <span class="badge bg-danger">Ended</span>
                        @endif
                    </td>
                    @else
                    @if($data->status == 3)
                    <td>
                        <span class="badge bg-danger">Cancelled</span>
                    </td>
                    @else
                    @if($data->payment_status == 0)
                    <td>
                        <span class="badge bg-warning">Pending</span>
                    </td>
                    @elseif($data->payment_status == 2)
                    <td>
                        <span class="badge bg-danger">Due</span>
                    </td>
                    @else
                    <td>
                        <form action="{{ route('appointments.update-status', $data->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select" onchange="this.form.submit()" required>
                                <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Started</option>
                                <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>Ended</option>
                            </select>
                        </form>
                    </td>
                    @endif
                    @endif
                    @endif
                    <td>
                        @if($data->status == 3)
                        <span class="badge bg-danger">Cancelled</span>
                        @else
                        @if($data->payment_status == 0)
                        <span class="badge bg-warning">Pending</span>
                        @elseif($data->payment_status ==1)
                        <span class="badge bg-success">Paid</span>
                        @else
                        <span class="badge bg-danger">Due</span>
                        @endif
                        @endif
                    </td>

                    {{-- Action buttons for editing and deleting --}}

                    @if(auth()->user()->hasRole('Patient'))
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionsDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionsDropdown">
                                @if($data->prescriptions->count() > 0)
                                <li><a href="{{ route('appointments.prescription', $data->id)}}"
                                        class="dropdown-item">See Prescription</a></li>
                                @endif
                                @if($data->tests->count() > 0)
                                <li><a href="{{ route('appointments.test', $data->id) }}" class="dropdown-item">See Test
                                        Report</a></li>
                                @endif

                                @if($data->payment_status == 2)
                                <li>
                                    <a href="#" class="dropdown-item text-success">Pay Now</a>
                                </li>
                                @else
                                @endif
                            </ul>
                        </div>
                    </td>
                    @else
                    <td style="min-width: 120px" class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                @if($data->status != 3)
                                <li>
                                    <a class="dropdown-item" href="{{ route('appointments.edit', $data->id) }}"
                                        title="Edit">Edit
                                    </a>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#createPrescriptionModal" data-appointment-id="{{ $data->id }}">
                                        Create Prescription
                                    </button>
                                </li>
                                @if($data->prescriptions->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ route('appointments.prescription', $data->id) }}"
                                        title="View Prescription">View Prescription
                                    </a>
                                </li>
                                @endif

                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#createTestModal" data-appointment-id="{{ $data->id }}">
                                        Create Test
                                    </button>
                                </li>
                                @if($data->tests->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ route('appointments.test', $data->id) }}"
                                        title="View Tests">View Tests
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <form action="{{ route('appointments.update-status', $data->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        <input type="hidden" name="status" value="3">
                                        <button type="submit" class="dropdown-item"
                                            onclick="return confirm('Are you sure to Cancel?')" title="Cancel">
                                            Cancel
                                        </button>
                                    </form>
                                </li>
                                @endif

                                <li>
                                    <form action="{{ route('appointments.destroy', $data->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete?')" title="Delete">
                                            Delete
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No data found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $appointments->links() }}
    </div>
</div>

<div class="modal fade" id="createTestModal" tabindex="-1" aria-labelledby="createTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('appointments.store-test') }}" method="POST">
            @csrf
            <input type="hidden" name="appointment_id" id="testAppointmentId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTestModalLabel">Create Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="test_name" class="form-label">Test Name</label>
                        <input type="text" name="test_name" id="test_name" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="test_result" class="form-label">Test Result</label>
                        <input type="text" name="test_result" id="test_result" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label for="test_note" class="form-label">Test Note</label>
                        <textarea name="test_note" id="test_note" class="form-control"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="test_link" class="form-label">Test Link</label>
                        <input type="url" name="test_link" id="test_link" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Test</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="createPrescriptionModal" tabindex="-1" aria-labelledby="createPrescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('appointments.store-prescription') }}" method="POST">
            @csrf
            <input type="hidden" name="appointment_id" id="prescriptionAppointmentId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPrescriptionModalLabel">Create Prescription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="prescription_link" class="form-label">Prescription Link</label>
                        <input type="url" name="prescription_link" id="prescription_link" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control summernote" rows="3"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Prescription</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    const testModal = document.getElementById('createTestModal');
    const prescriptionModal = document.getElementById('createPrescriptionModal');

    testModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const appointmentId = button.getAttribute('data-appointment-id');
        document.getElementById('testAppointmentId').value = appointmentId;
    });

    prescriptionModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const appointmentId = button.getAttribute('data-appointment-id');
        document.getElementById('prescriptionAppointmentId').value = appointmentId;
    });
</script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200, // Set editor height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<script>
    function copyLink(link, id) {
        navigator.clipboard.writeText(link).then(() => {
            const copyMsg = document.getElementById(`copy-msg-${id}`);
            if (copyMsg) {
                copyMsg.style.display = 'inline';
                setTimeout(() => {
                    copyMsg.style.display = 'none';
                }, 2000);
            }
        }).catch(err => {
            console.error('Failed to copy link: ', err);
        });
    }
</script>
@endpush