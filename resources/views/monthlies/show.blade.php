@extends('layouts.app')

@section('title', __('Detail of Monthlies'))

@section('content')

    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @endpush

    <!-- Modal for adding data -->
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('store-earning-deduction') }}">
                    <div class="modal-body">
                        @csrf <!-- Menambahkan token CSRF -->
                        <input type="hidden" id="employee_id" name="employee_id" value="{{ $monthlies->karyawan_id }}">
                        <input type="hidden" id="period" name="period" value="{{ $monthlies->period }}">

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" readonly required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"
                                name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" placeholder="Enter amount"
                                name="amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Monthlies') }}</h3>
                    <p class="text-subtitle text-muted">{{ __('Detail of monthly.') }}</p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('monthlies.index') }}">{{ __('Monthlies') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="fw-bold">{{ __('Employee Name') }}</td>
                                        <td>{{ $monthlies->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Employee ID') }}</td>
                                        <td>{{ $monthlies->employee_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Branch Office') }}</td>
                                        <td>{{ $monthlies->branch_office_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Designation') }}</td>
                                        <td>{{ $monthlies->job_position }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $monthlies->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Period') }}</td>
                                        <td>{{ $monthlies->period }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="fw-bold">{{ __('Salary Monthly') }}</td>
                                        <td colspan="2"><b>{{ currency($monthlies->salary_monthly) }}</b></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Salary Daily') }}</td>
                                        <td colspan="2"><b>{{ currency($monthlies->salary_daily) }}</b></td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold" style="background-color: green;color:white">
                                            {{ __('Total Earnings') }}
                                        </td>
                                        <td colspan="2" class="fw-bold" style="background-color: green;color:white">
                                            {{ currency($monthlies->total_earnings + $monthlies->craft_incentives_payroll + $monthlies->meal_allowance_payroll) }}
                                            <!-- Button to trigger modal for adding earnings data -->
                                            <button class="btn btn-sm btn-light" data-bs-toggle="modal"
                                                data-bs-target="#addDataModal" onclick="setModalType('earning')">
                                                <i class="fa fa-plus"></i> Add Earning
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Craft Incentives') }}</td>
                                        <td colspan="2">
                                            Jumlah Hari Kerja: {{ $monthlies->jumlah_hari_kerja }}<br>
                                            Jumlah Masuk Kerja: {{ $monthlies->jumlah_masuk }} <br>
                                            Jumlah Tidak Masuk:
                                            {{ $monthlies->jumlah_hari_kerja - $monthlies->jumlah_masuk }}<br>
                                            Benefit Craft Incentives:
                                            <b>{{ currency($monthlies->craft_incentives_payroll) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Meal Allowance') }}</td>
                                        <td colspan="2"><b>{{ currency($monthlies->meal_allowance_payroll) }}</b></td>
                                    </tr>
                                    @foreach ($earnings as $earning)
                                        <tr>
                                            <td class="fw-bold">{{ $earning->name }}</td>
                                            <td>
                                                <b>{{ currency($earning->amount) }}</b>
                                            </td>
                                            <td>
                                                <form action="{{ route('monthly.earning-deduct.destroy', $earning->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit"
                                                        style="margin-left: 10px;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td class="fw-bold" style="background-color: red;color:white">
                                            {{ __('Total Deduction') }}</td>
                                        <td colspan="2" class="fw-bold" style="background-color: red;color:white">
                                            {{ currency($monthlies->total_deductions + $monthlies->potongan_telat_absen) }}
                                            <!-- Button to trigger modal for adding deduction data -->
                                            <button class="btn btn-sm btn-light" data-bs-toggle="modal"
                                                data-bs-target="#addDataModal" onclick="setModalType('deduction')">
                                                <i class="fa fa-plus"></i> Add Deduction
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Potongan Telat Absen') }}</td>
                                        <td colspan="2">({{ $monthlies->telat_absen }} X {{ currency(10000) }} =
                                            <b>{{ currency($monthlies->potongan_telat_absen) }})</b>
                                            <br>
                                            <i>Telat Absen x 10.000</i>
                                        </td>
                                    </tr>
                                    @foreach ($deductions as $deduction)
                                        <tr>
                                            <td class="fw-bold">{{ $deduction->name }}</td>
                                            <td>
                                                <b>{{ currency($deduction->amount) }}</b>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('monthly.earning-deduct.destroy', $deduction->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit"
                                                        style="margin-left: 10px;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="fw-bold" style="background-color: grey;color:white">
                                            {{ __('Nett Salary') }}</td>
                                        <td colspan="2" class="fw-bold" style="background-color: grey;color:white">
                                            {{ currency($monthlies->final_salary) }} <br>
                                            <i>Salary Monthly + Salary Daily + Total Earnings - Total Deduction</i>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <a href="{{ route('monthlies.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script>
        function setModalType(type) {
            const statusInput = document.getElementById('status');
            if (type === 'earning') {
                statusInput.value = 'earning';
            } else if (type === 'deduction') {
                statusInput.value = 'deduction';
            }
        }
    </script>
@endpush
