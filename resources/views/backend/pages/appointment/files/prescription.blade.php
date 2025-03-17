@extends('backend.layouts.master')
@section('content')

<div class="shadow-sm card">
    <!-- Prescription Title -->
    <div class="py-4 card-body">
        <div class="text-center">
            <h2 class="text-uppercase">Prescription</h2>
            <p class="text-muted">Appointment ID: #{{ $appointment->id }}</p>
            <p class="text-muted">Doctor: {{ $appointment->doctor->fullName() }}</p>
            <p class="text-muted">Date: {{ \Carbon\Carbon::parse($appointment->appoinment_date)->format('D, d M Y') }}</p>
        </div>
        <hr class="my-4">
        
        <!-- Print Button -->
        <div class="mb-3 text-end no-print">
            <button id="printPrescription" class="btn btn-success btn-sm">
                <i class="bi bi-printer"></i> Print Prescription
            </button>
        </div>

        <!-- Prescription Details -->
        <div class="px-5 prescription-details" id="prescriptionContent">
            @foreach($appointment->prescriptions as $prescription)
            <div class="mb-5">
                <h4 class="text-primary">Prescription #{{ $loop->iteration }}</h4>
                <div class="ps-3">
                    <h5>Description</h5>
                    <!-- Render HTML content from Summernote -->
                    <p>{!! $prescription->description !!}</p>

                    <h5 class="no-print">Prescription Link</h5>
                    <a href="{{ $prescription->prescription_link }}" target="_blank" class="btn btn-outline-primary btn-sm no-print">
                        Download Prescription
                    </a>

                    <h5>Date Issued</h5>
                    <p>{{ \Carbon\Carbon::parse($prescription->date)->format('D, d M Y H:i A') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .prescription-details h4 {
        font-size: 1.5rem;
        border-left: 4px solid #007bff;
        padding-left: 10px;
        margin-bottom: 15px;
    }

    .prescription-details h5 {
        font-size: 1.2rem;
        color: #333;
        margin-top: 10px;
    }

    .prescription-details p {
        font-size: 1rem;
        color: #555;
    }

    .prescription-details a {
        font-size: 0.9rem;
        margin-top: 5px;
        display: inline-block;
    }

    .prescription-details .text-success {
        color: #28a745;
    }

    .prescription-details .text-danger {
        color: #dc3545;
    }

    /* Hide elements in print */
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('printPrescription').addEventListener('click', function () {
        var printContents = document.getElementById('prescriptionContent').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Reload the page after printing to restore the original view
        window.location.reload();
    });
</script>
@endpush
