@extends('backend.layouts.master')

@section('content')

<div class="card">
    <div class="card-body">
        <form>
            <div class="mt-3 row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Phone" name="phone"
                        value="{{ old('phone', $filters['phone'] ?? '') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Transaction ID" name="transaction_id"
                        value="{{ old('transaction_id', $filters['transaction_id'] ?? '') }}">
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">Select Payment Status</option>
                        <option value="0" {{ (old('payment_status', $filters['payment_status'] ?? '') == '0') ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ (old('payment_status', $filters['payment_status'] ?? '') == '1') ? 'selected' : '' }}>Paid</option>
                        <option value="2" {{ (old('payment_status', $filters['payment_status'] ?? '') == '2') ? 'selected' : '' }}>Due</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Payment List</h4>
            </div>
            <div class="mt-1 col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('payments.create') }}">
                    <i class="bi bi-plus"></i> Add New Payment
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <x-table
            :columns="['#', 'Appointment ID', 'Patient Name', 'Phone', 'Amount', 'Transaction ID', 'Payment Status', 'Action']">
            @forelse($paymentInfo as $key => $payment)
            <tr class="text-center">
                <td>{{ $key + 1 + ($paymentInfo->currentPage() - 1) * $paymentInfo->perPage() }}</td>
                <td>{{ $payment->appoinment_id }}</td>
                <td>{{ $payment->patient->fullName() }}</td>
                <td>{{ $payment->phone }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->transaction_id }}</td>
                {{-- <td>
                    <span class="badge {{ $payment->payment_status ? 'bg-success' : 'bg-danger' }}">
                        {{ $payment->payment_status ? 'Paid' : 'Unpaid' }}
                    </span>
                </td> --}}
                <td>
                    <form action="{{ route('payments.update-status', $payment->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select" onchange="this.form.submit()" required>
                            <option value="0" {{ (int) $payment->payment_status === 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ (int) $payment->payment_status === 1 ? 'selected' : '' }}>Paid</option>
                            <option value="2" {{ (int) $payment->payment_status === 2 ? 'selected' : '' }}>Due</option>
                            {{-- <option value="3" {{ (int) $payment->payment_status === 3 ? 'selected' : '' }}>Cancel</option> --}}
                        </select>
                    </form>
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="#" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a class="btn btn-danger btn-sm" href="#" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>
                    {{-- <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                        style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                            onclick="return confirm('Are you sure to delete?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form> --}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No data found</td>
            </tr>
            @endforelse
        </x-table>
        <div class="d-flex justify-content-end">
            {{ $paymentInfo->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
@endpush