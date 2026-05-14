@extends('layouts.app')

@section('title', __('Monthlies'))

@section('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Monthly Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('action-import-monthlies') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" accept=".xlsx" class="form-control" id="import_employees" name="import_employees" aria-describedby="import_employees" required>
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
                    <h3>{{ __('Monthlies') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all monthlies.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Monthlies') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

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

                                        <div class="col-md-3">
                                            <input type="month" id="month" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <button id="downloadFormat" class="btn btn-success  mb-3">
                                                <i class='fas fa-file-excel'></i>
                                                {{ __('Export') }}
                                            </button>&nbsp;
                                            <button type="button" class="btn btn-warning  mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                                Import
                                            </button> --}}
                                            <button type="button" onclick="confirmGenerate()" class="btn btn-primary mb-3">
                                                <i class='fa fa-redo'></i> Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Period') }}</th>
                                            <th>{{ __('Payroll Type') }}</th>
                                            <th>{{ __('Salary Monthly') }}</th>
                                            <th>{{ __('Salary Daily') }}</th>
                                            <th>{{ __('Total Earnings ') }}</th>
                                            <th>{{ __('Total Deductions') }}</th>
                                            <th>{{ __('Final Salary') }}</th>
                                            <th>{{ __('Is Send ?') }}</th>
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

    <form action="/monthlies/generate" method="POST" id="form-generate-monthly">
        @csrf

        <input type="hidden" name="department_id" id="department_id">
        <input type="hidden" name="month_generate" id="month_generate">
    </form>
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
        $(document).ready(function() {
            // Get the current date
            var currentDate = new Date();

            // Get the current month and year
            var currentMonth = currentDate.getMonth() + 1; // Months are zero-based
            var currentYear = currentDate.getFullYear();

            // Format the date as "YYYY-MM" (assuming an input with type 'month')
            var formattedDate = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth;

            // Set the value of the input field with id "monthInput"
            $('#month').val(formattedDate);
        });
    </script>
    <script>


        let columns = [
            {
                data: 'full_name',
                name: 'full_name'
            },
            {
                data: 'period',
                name: 'period',
            },
            {
                data: 'payroll_type',
                name: 'payroll_type',
            },
            {
                data: 'salary_monthly',
                name: 'salary_monthly',
            },
            {
                data: 'salary_daily',
                name: 'salary_daily',
            },
            {
                data: 'total_earnings',
                name: 'total_earnings',
            },
            {
                data: 'total_deductions',
                name: 'total_deductions',
            },
            {
                data: 'final_salary',
                name: 'final_salary',
            },
            {
                data: 'is_send',
                name: 'is_send',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('monthlies.index') }}",
                data: function(s) {
                    s.departement = $('select[name=departement] option').filter(':selected').val()
                    s.month = $('#month').val();
                }
            },
            columns: columns
        });
        $('#departement').change(function() {
            table.draw();
        })
        $('#month').change(function() {
            table.draw();
        })
    </script>

    <script>
        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();

        });

        var downloadFormat = function() {
            var departement = $('select[name=departement] option').filter(':selected').val()
            var month = $('#month').val();
            var url = '/download-format-monthlies/' + departement + '/' + month;;
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    departement: departement,
                    month: month,
                },
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
                    var nameFile = 'format_import_salary .xlsx'
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
        function openEmailModal(modelId, fullName, period) {
            var baseUrl = "{{ url('/slip') }}";
            var fullUrl = baseUrl + "/" + modelId;

            // Set the necessary data in the modal elements
            $('#emailConfirmationModal #modelId').val(modelId);
            $('#emailConfirmationModal #title').val('Salary Slip ' + period);
            var emailContent = "Hi " + fullName + ",\n\nThis is automation email for your salary slip " + period + ",\n\nIf you have any questions, please feel free to email us at saepulramdan244@gmail.com\n\nTo see salary details, you can check the following link " + fullUrl + "\n\n\nThank you\nRMS Jaya Abadi Teknik";

            // Set the modified content in the textarea
            $('#emailConfirmationModal #emailBody').val(emailContent);

            // Show the modal
            $('#emailConfirmationModal').modal('show');
        }
    </script>
    <script>
        function confirmGenerate() {
            Swal.fire({
                title: 'Data payroll sebelumnya akan ter-replace.',
                text: "Apakah Anda yakin untuk generate ulang payroll?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Generate',
                cancelButtonText: 'No, Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    doGenerateMonthlies();
                }
            });
        }

        function doGenerateMonthlies() {
            const formGenerateMonthlyElement = document.getElementById('form-generate-monthly')
            formGenerateMonthlyElement.querySelector('#department_id').value = document.getElementById('departement').value
            formGenerateMonthlyElement.querySelector('#month_generate').value = $('#month').val()

            formGenerateMonthlyElement.submit()
        }
    </script>
@endpush
