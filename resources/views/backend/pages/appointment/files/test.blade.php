@extends('backend.layouts.master')
@section('content')

<div class="shadow-sm card">
    <!-- Test Report Title -->
    <div class="py-4 card-body">
        <div class="text-center">
            <h2 class="text-uppercase">Test Report</h2>
            <p class="text-muted">Appointment ID: #{{ $appointment->id }}</p>
            <p class="text-muted">Doctor: {{ $appointment->doctor->fullName() }}</p>
            <p class="text-muted">Date: {{ \Carbon\Carbon::parse($appointment->appoinment_date)->format('D, d M Y') }}</p>
        </div>
        <hr class="my-4">
        
        <!-- Print Button -->
        <div class="mb-3 text-end no-print">
            <button id="printTestReport" class="btn btn-success btn-sm">
                <i class="bi bi-printer"></i> Print Test Report
            </button>
        </div>

        <!-- Test Report Details -->
        <div class="px-5 test-report-details" id="testReportContent">
            @foreach($appointment->tests as $test)
            <div class="mb-5">
                <h4 class="text-primary">Test #{{ $loop->iteration }}</h4>
                <div class="ps-3">
                    <h5>Test Name</h5>
                    <p>{{ $test->test_name }}</p>

                    <h5>Test Result</h5>
                    <p>{{ $test->test_result }}</p>

                    <h5>Test Notes</h5>
                    <p>{{ $test->test_note }}</p>

                    <h5 class="no-print">Test Document</h5>
                    <a href="{{ $test->test_link }}" target="_blank" class="btn btn-outline-primary btn-sm no-print">
                        View Test Document
                    </a>

                    <h5>Date Conducted</h5>
                    <p>{{ \Carbon\Carbon::parse($test->date)->format('D, d M Y H:i A') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .test-report-details h4 {
        font-size: 1.5rem;
        border-left: 4px solid #007bff;
        padding-left: 10px;
        margin-bottom: 15px;
    }

    .test-report-details h5 {
        font-size: 1.2rem;
        color: #333;
        margin-top: 10px;
    }

    .test-report-details p {
        font-size: 1rem;
        color: #555;
    }

    .test-report-details a {
        font-size: 0.9rem;
        margin-top: 5px;
        display: inline-block;
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
    document.getElementById('printTestReport').addEventListener('click', function () {
        var printContents = document.getElementById('testReportContent').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    });
</script>
@endpush
