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
                <h4 class="card-title">Patient List</h4>
            </div>
            <div class="mt-1 col-md-6 text-end">
                <a class="btn btn-primary" href="{{ route('patients.create') }}" title="Add New Patient">
                    <i class="bi bi-plus"></i> Add New Patient
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <x-table :columns="['#', 'Name', 'Email', 'Phone', 'Gender', 'Age', 'Action']">
            @forelse($patients as $key => $data)
            <tr class="text-center">
                <td>{{ $key + 1 + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                <td>{{ $data->fname }} {{ $data->lname }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->phone }}</td>
                <td>{{ $data->patientInfo->gender }}</td>
                <td>{{ $data->patientInfo->age }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('patients.edit', $data->id) }}" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('patients.destroy', $data->id) }}" method="POST"
                        style="display: inline-block">
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
                <td colspan="6" class="text-center">No data found</td>
            </tr>
            @endforelse
        </x-table>
        <div class="d-flex justify-content-end">
            {{ $patients->links() }}
        </div>
    </div>

</div>

@endsection

@push('scripts')
@endpush