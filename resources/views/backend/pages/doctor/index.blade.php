@extends('backend.layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <form>
            <div class="mt-3 row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Name" name="name"
                        value="{{ request()->name }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Phone" name="phone"
                        value="{{ request()->phone }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-danger">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Doctor List</h4>
            </div>
            <div class="mt-1 col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('doctors.create') }}" title="Add New Doctor">
                    <i class="bi bi-plus"></i> Add New Doctor
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <x-table :columns="['#', 'Image', 'Name', 'Email', 'Phone', 'Speciality', 'Department', 'Designation', 'Fee', 'Action']">
            @forelse($doctors as $key => $data)
            <tr class="text-center">
                <td>{{ $key + 1 + ($doctors->currentPage() - 1) * $doctors->perPage() }}</td>

                <!-- Doctor Image -->
                <td>
                    <img src="{{ $data->image ? asset('backend/assets/images/users/' . $data->image) : asset('uploads/user.png') }}" 
                        alt="Doctor Image" class="rounded-circle" width="50" height="50">
                </td>

                <!-- Doctor Details -->
                <td>{{ $data->fname }} {{ $data->lname }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->phone }}</td>
                <td>{{ $data->doctorInfo->speciality ?? 'N/A' }}</td>
                <td>{{ $data->doctorInfo->department->name ?? 'N/A' }}</td>
                <td>{{ $data->doctorInfo->designation->name ?? 'N/A' }}</td>
                <td>BDT {{ number_format($data->doctorInfo->fee, 2) }}</td>

                <!-- Action Buttons -->
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('doctors.edit', $data->id) }}" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('doctors.destroy', $data->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                            onclick="return confirm('Are you sure to delete?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">No data found</td>
            </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $doctors->links() }}
        </div>
    </div>
</div>


@endsection

@push('scripts')
@endpush