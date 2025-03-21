@extends('backend.layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Edit Appointment</h4>
            </div>
            <div class="mt-1 col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('appointments.index') }}">
                    <i class="bi bi-list"></i> Appointment List
                </a>
            </div>
        </div>
    </div>
    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Method for updating -->
        <div class="py-3 card-body">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="row">
                        <div class="mb-2 form-group col-md-6">
                            <label for="appoinment_date">Appointment Date and Time:</label>
                            <input type="datetime-local" name="appoinment_date" id="appoinment_date" class="form-control" 
                                value="{{ \Carbon\Carbon::parse($appointment->appoinment_date)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="mb-2 form-group col-md-6">
                            <label for="duration">Duration (in minutes):</label>
                            <input type="number" name="duration" id="duration" class="form-control" value="{{ $appointment->duration }}" required>
                        </div>
                        <div class="mb-2 form-group">
                            <label for="appoinment_note">Appointment Note:</label>
                            <textarea name="appoinment_note" id="appoinment_note" class="form-control" rows="3">{{ $appointment->appoinment_note }}</textarea>
                        </div>
                        <div class="mb-2 form-group">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3">{{ $appointment->comment }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3 text-center card-footer">
            <button type="submit" class="btn btn-primary">Update Appointment</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@endpush
