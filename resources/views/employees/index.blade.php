@extends('layouts.app')

@section('title', __('Employees'))

@section('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('action-import-employees') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" accept=".xlsx" class="form-control" id="import_employees" name="import_employees" aria-describedby="import_employees" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a> </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Employees') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all employees.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Employees') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('employee create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new employee') }}
                    </a>&nbsp;
                    <button id="btnPdf" class="btn btn-danger  mb-3">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        {{ __('PDF') }}
                    </button>&nbsp;
                    <button id="btnExport" class="btn btn-success  mb-3">
                        <i class='fas fa-file-excel'></i>
                        {{ __('Export') }}
                    </button>&nbsp;
                    <button type="button" class="btn btn-warning  mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                        Import
                    </button>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <select name="departement" id="departement" class="form-control  js-example-basic-single">
                                                <option value="All">All Department
                                                </option>
                                                @foreach ($departement as $row)
                                                    <option value="{{ $row->id }}">{{ $row->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="work_status" id="work_status" class="form-control  js-example-basic-single">
                                                <option value="All">All Work Status
                                                </option>
                                                <option value="Active">Active</option>
                                                <option value="Non Active">Non Active</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="use_gps_location" id="use_gps_location" class="form-control  js-example-basic-single">
                                                <option value="All">All Use GPS Location
                                                </option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Employee Id') }}</th>
                                            <th>{{ __('Full Name') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th>{{ __('Work Status') }}</th>
                                            <th>{{ __('Use GPS Location') }}</th>
                                            <th>{{ __('Start Contract Date') }}</th>
                                            <th>{{ __('End Contract Date') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script>
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Email</td>' +
                '<td>:</td>' +
                '<td>' + d.email + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Gender</td>' +
                '<td>:</td>' +
                '<td>' + d.gender + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Date Of Birth</td>' +
                '<td>:</td>' +
                '<td>' + d.date_of_birth + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Martial Status</td>' +
                '<td>:</td>' +
                '<td>' + d.martial_status + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Id Type</td>' +
                '<td>:</td>' +
                '<td>' + d.id_type + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>National Id No</td>' +
                '<td>:</td>' +
                '<td>' + d.national_id_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Job Position</td>' +
                '<td>:</td>' +
                '<td>' + d.job_position + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Work Location</td>' +
                '<td>:</td>' +
                '<td>' + d.branch_office_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Bpjs Tk No</td>' +
                '<td>:</td>' +
                '<td>' + d.bpjs_tk_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Bpjs Health No</td>' +
                '<td>:</td>' +
                '<td>' + d.bpjs_health_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Tax ID</td>' +
                '<td>:</td>' +
                '<td>' + d.tax_id + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Medical Insurance</td>' +
                '<td>:</td>' +
                '<td>' + d.medical_insurance + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Currency</td>' +
                '<td>:</td>' +
                '<td>' + d.currency + '</td>' +
                '</tr>' +

                '<tr>' +
                '<td>Payroll Type</td>' +
                '<td>:</td>' +
                '<td>' + d.payroll_type.split('_').join(' ').replace(/(^\w{1})|(\s+\w{1})/g, letter => letter.toUpperCase()) + '</td>' +
                '</tr>' +
                (
                    d.payroll_type == 'monthly' || d.payroll_type == 'monthly_and_daily' ? '<tr>' +
                    '<td>Monthly Salary</td>' +
                    '<td>:</td>' +
                    '<td>' + d.salary + '</td>' +
                    '</tr>' : ''
                ) +
                (
                    d.payroll_type == 'daily' || d.payroll_type == 'monthly_and_daily' ? '<tr>' +
                    '<td>Daily Salary</td>' +
                    '<td>:</td>' +
                    '<td>' + d.daily_salary + '</td>' +
                    '</tr>' : ''
                ) +
                (
                    d.departement_id != '5' ? '<tr>' +
                    '<td>Meal Allowance/Day</td>' +
                    '<td>:</td>' +
                    '<td>' + d.meal_allowance + '</td>' +
                    '</tr>' : ''
                ) +
                '<tr>' +
                '<td>Address</td>' +
                '<td>:</td>' +
                '<td>' + d.address + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Use GPS Location</td>' +
                '<td>:</td>' +
                '<td>' + d.use_gps_location + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Bank Name</td>' +
                '<td>:</td>' +
                '<td>' + d.bank_name + '</td>' +
                '</tr>' +
                '<td>Bank Account Name</td>' +
                '<td>:</td>' +
                '<td>' + d.bank_account_name + '</td>' +
                '</tr>' +
                '<td>Bank Account Number</td>' +
                '<td>:</td>' +
                '<td>' + d.bank_account_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td>Created At</td>' +
                '<td>:</td>' +
                '<td>' + d.created_at + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Updated At</td>' +
                '<td>:</td>' +
                '<td>' + d.updated_at + '</td>' +
                '</tr>' +
                '</table>';
        }


        $('#data-table').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
            } else {
                // Open this row
                row.child(format(row.data())).show();
            }
        });

        $('#data-table').on('requestChild.dt', function(e, row) {
            row.child(format(row.data())).show();
        })

        let columns = [{
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            }, {
                data: 'employee_id',
                name: 'employee_id',
                orderable: false,
            },
            {
                data: 'full_name',
                name: 'full_name',
                orderable: false,
            },
            {
                data: 'department',
                name: 'department.department_name',
                orderable: false,
            },
            {
                data: 'work_status',
                name: 'work_status',
                orderable: false,
            },
            {
                data: 'use_gps_location',
                name: 'use_gps_location',
                orderable: false,
            },
            {
                data: 'start_contract_date',
                name: 'start_contract_date',
            },
            {
                data: 'end_contract_date',
                name: 'end_contract_date',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employees.index') }}",
                data: function(s) {
                    s.departement = $('select[name=departement] option').filter(':selected').val()
                    s.work_status = $('select[name=work_status] option').filter(':selected').val()
                    s.use_gps_location = $('select[name=use_gps_location] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        $('#departement').change(function() {
            table.draw();
        })
        $('#work_status').change(function() {
            table.draw();
        })
        $('#use_gps_location').change(function() {
            table.draw();
        })
    </script>
    <script>
        const showLoading = function() {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                () => {},
                (dismiss) => {
                    if (dismiss === 'timer') {
                        console.log('closed by timer!!!!');
                        swal({
                            title: 'Finished!',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                }
            )
        };

        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();

        });
        var exportData = function() {
            var departement = $('select[name=departement] option').filter(':selected').val()
            var work_status = $('select[name=work_status] option').filter(':selected').val()
            var use_gps_location = $('select[name=use_gps_location] option').filter(':selected').val()

            var url = '/export-data-employees/' + departement + '/' + work_status + '/' + use_gps_location;
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    departement: departement,
                    work_status: work_status,
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan proses export data', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'Daftar-employees.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Data export failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>

    <script>
        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();

        });

        var downloadFormat = function() {
            var url = '/download-format-employees';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan download format import',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'format_import_employees.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Download Format Import failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>

    <script>
        $(document).on('click', '#btnPdf', function(event) {
            event.preventDefault();
            cetakPdf();
        });
        var cetakPdf = function() {
            var departement = $('select[name=departement] option').filter(':selected').val()
            var work_status = $('select[name=work_status] option').filter(':selected').val()
            var use_gps_location = $('select[name=use_gps_location] option').filter(':selected').val()
            var url = '/pdf-employees/' + departement + '/' + work_status + '/' + use_gps_location;
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    departement: departement,
                    work_status: work_status,
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan proses print data', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'list-employees.pdf'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Data export failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
