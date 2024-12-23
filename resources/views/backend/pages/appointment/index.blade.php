@extends('backend.layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Appointment Note" name="note"
                        value="{{ request()->note }}">
                </div>

                @if(auth()->user()->hasRole('Super Admin'))
                <!-- Corrected role name -->
                <div class="col-md-3">
                    <select class="form-select" name="doctor_id">
                        <option value="">Select Doctor</option>
                        @foreach(\App\Models\User::where('type', 'doctor')->get() as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id')==$doctor->id ? 'selected' : '' }}>{{
                            $doctor->fname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="patient_id">
                        <option value="">Select Patient</option>
                        @foreach(\App\Models\User::where('type', 'patient')->get() as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id')==$patient->id ? 'selected' : ''
                            }}>{{ $patient->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Appointment List</h4>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('appointments.create') }}">
                    <i class="bi bi-plus"></i> Add New
                </a>
            </div>
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
                    {{-- Start Meeting --}}
                    <th>Start Meeting</th>
                    <th>Status</th>
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
                    {{-- Start meeting button with Mark as Started --}}
                    <td>
                        <form action="{{ route('appointments.update-status', $data->id) }}" method="POST">
                            @csrf
                            @if($data->status == 2)
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm disabled"
                                title="Meeting Ended">
                                <i class="bi bi-camera-video"></i> Meeting Ended
                            </a>
                            @else
                            <a href="{{ $data->start_url }}" target="_blank" class="btn btn-primary btn-sm"
                                title="Start Meeting">
                                <i class="bi bi-camera-video"></i> Start Meeting
                                <input type="hidden" name="status" value="started">
                            </a>
                            @endif
                        </form>
                    </td>

                    {{-- Display meeting status --}}
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

                    {{-- Action buttons for editing and deleting --}}
                    <td style="min-width: 100px" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('appointments.edit', $data->id) }}" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('appointments.destroy', $data->id) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure to delete?')" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No data found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $appointments->links() }}
    </div>
</div>

@endsection

@push('scripts')
@endpush