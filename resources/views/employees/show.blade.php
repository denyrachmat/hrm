@extends('layouts.app')

@section('title', __('Detail of Employees'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Employees') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of employee.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('employees.index') }}">{{ __('Employees') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-xs">
                                    <tr>
                                        <td class="fw-bold">{{ __('Photo') }}</td>
                                        <td>
                                            <img src="{{ $employee->photo ? '/storage/employees/photo/' . $employee->photo : '/images/no-photo.png' }}"
                                                alt="photo" class="rounded" width="75" height="75"
                                                style="object-fit: cover">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Employee Id') }}</td>
                                        <td>{{ $employee->employee_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Full Name') }}</td>
                                        <td>{{ $employee->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $employee->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Gender') }}</td>
                                        <td>{{ $employee->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Date Of Birth') }}</td>
                                        <td>{{ $employee->date_of_birth }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Martial Status') }}</td>
                                        <td>{{ $employee->martial_status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Id Type') }}</td>
                                        <td>{{ $employee->id_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('National Id No') }}</td>
                                        <td>{{ $employee->national_id_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Start Contract Date') }}</td>
                                        <td>{{ $employee->start_contract_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('End Contract Date') }}</td>
                                        <td>{{ $employee->end_contract_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Job Position') }}</td>
                                        <td>{{ $employee->job_position }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Branch Office') }}</td>
                                        <td>{{ $employee->branch_office_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Department') }}</td>
                                        <td>{{ $employee->department_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bpjs Tk No') }}</td>
                                        <td>{{ $employee->bpjs_tk_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bpjs Health No') }}</td>
                                        <td>{{ $employee->bpjs_health_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tax ID') }}</td>
                                        <td>{{ $employee->tax_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Medical Insurance') }}</td>
                                        <td>{{ $employee->medical_insurance }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Work Status') }}</td>
                                        <td>{{ $employee->work_status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Payroll Type') }}</td>
                                        <td>{{ ucwords(join(' ', explode('_', $employee->payroll_type))) }}</td>
                                    </tr>
                                    @if ($employee->payroll_type == 'monthly' || $employee->payroll_type == 'monthly_and_daily')
                                        <tr>
                                            <td class="fw-bold">{{ __('Monthly Salary') }}</td>
                                            <td>{{ $employee->salary }}</td>
                                        </tr>
                                    @endif
                                    @if ($employee->payroll_type == 'daily' || $employee->payroll_type == 'monthly_and_daily')
                                        <tr>
                                            <td class="fw-bold">{{ __('Daily Salary') }}</td>
                                            <td>{{ $employee->daily_salary }}</td>
                                        </tr>
                                    @endif
                                    @if ($employee->department_id != '5')
                                        <tr>
                                            <td class="fw-bold">{{ __('Meal Allowance/Day') }}</td>
                                            <td>{{ $employee->meal_allowance }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-bold">{{ __('Address') }}</td>
                                        <td>{{ $employee->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bank Name') }}</td>
                                        <td>{{ $employee->bank_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bank Account Name') }}</td>
                                        <td>{{ $employee->bank_account_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bank Account Number') }}</td>
                                        <td>{{ $employee->bank_account_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <button style="margin-bottom: 5px" type="button" class="btn btn-success btn-sm"
                                data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add
                            </button>
                            <div class="modal fade" id="exampleModal2" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Employee FIle</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('action-save-file') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <div class="mb-3">
                                                    <label for="">File Name</label>
                                                    <input type="text" required name="file_name" class="form-control"
                                                        id="file_name">
                                                    <input type="hidden" required name="employee_id"
                                                        class="form-control" value="{{ $employee->id }}"
                                                        id="employee_id">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">File</label>
                                                    <input type="file" required name="file" class="form-control"
                                                        id="file">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">File Name</th>
                                        <th scope="col">File</th>
                                        <th scope="col" style="width: 5px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee_files as $row)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $row->file_name }}</td>
                                            <td> <a href="{{ asset('storage/employee-file/file/' . $row->file) }}"
                                                    target="_blank">View <i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                            <td>
                                                <form action="{{ route('action-delete-file', $row->id) }}" method="post"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure to delete this record?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>


                            <!-- Add Family Modal -->
                            <button style="margin-bottom: 5px"  class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addFamilyModal">
                                <i class="fa fa-plus"></i> Add Family
                            </button>

                            <div class="modal fade" id="addFamilyModal" tabindex="-1" aria-labelledby="addFamilyLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFamilyLabel">Add Family Member</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('employee-family.store') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="relationship" class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" id="relationship"
                                                        name="relationship" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" id="date_of_birth"
                                                        name="date_of_birth">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contact_person" class="form-label">Contact Person</label>
                                                    <input type="text" class="form-control" id="contact_person"
                                                        name="contact_person">
                                                </div>
                                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Date of Birth</th>
                                        <th>CP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($families as $family)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $family->name }}</td>
                                            <td>{{ $family->relationship }}</td>
                                            <td>{{ $family->date_of_birth }}</td>
                                            <td>{{ $family->contact_person }}</td>
                                            <td>
                                                <form action="{{ route('employee-family.destroy', $family->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
