@extends('layouts.app')

@section('title', __('Edit Earnings'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Earnings') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Edit a earning.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('earnings.index') }}">{{ __('Earnings') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Edit') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-primary d-flex align-items-center" style="gap: 4px" data-bs-toggle="modal" data-bs-target="#modalCreateEarning"><i class="bi bi-plus"></i> Add Earning</button>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">

                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            <strong>Success!</strong> {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-body">

                            <div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($earnings as $key => $earning)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $earning->name }}</td>
                                                <td>{{ $earning->amount }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 4px">
                                                        <button class="btn btn-primary btn-sm d-flex align-items-center" style="gap: 4px" data-bs-toggle="modal" data-bs-target="#modalEditEarning{{ $earning->id }}"><i class="bi bi-pencil"></i> Edit</button>
                                                        <button class="btn btn-sm btn-danger d-flex align-items-center" style="gap: 2px" onclick="deleteEarning({{ $earning->id }}, '{{ $earning->name }}')"><i class="bi bi-trash"></i> Delete</button>
                                                    </div>


                                                    {{-- Modal Edit --}}
                                                    <div class="modal fade" id="modalEditEarning{{ $earning->id }}" tabindex="-1" aria-labelledby="modalEditEarning{{ $earning->id }}Label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="/employee-earnings/{{ $earning->id }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalEditEarning{{ $earning->id }}Label">Edit Earning</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group mb-3">
                                                                            <label for="name" class="form-label mb-1">Name</label>
                                                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required value="{{ $earning->name }}">
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="amount" class="form-label mb-1">Amount</label>
                                                                            <input type="number" min="1" name="amount" id="amount" class="form-control" placeholder="Amount" required value="{{ $earning->amount }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End of Modal Edit --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Employee</th>
                                    <th>:</th>
                                    <td>{{ $employee->full_name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreateEarning" tabindex="-1" aria-labelledby="modalCreateEarningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/employee-earnings/{{ $employee->id }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateEarningLabel">Add Earning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label mb-1">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="amount" class="form-label mb-1">Amount</label>
                            <input type="number" min="1" name="amount" id="amount" class="form-control" placeholder="Amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of Modal Create --}}

    <form action="" id="form-delete-earning" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <script>
        function deleteEarning(id, name) {
            if (confirm('Are you sure to delete earning ' + name)) {
                const formDeleteElement = document.getElementById('form-delete-earning')
                formDeleteElement.setAttribute('action', '/employee-earnings/' + id)
                formDeleteElement.submit()
            }
        }
    </script>
@endpush
