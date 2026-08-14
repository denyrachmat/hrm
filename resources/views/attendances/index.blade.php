@extends('layouts.app')

@section('title', __('Attendances'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Attendances') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all attendances.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Attendances') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            {{-- @can('attendance create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new attendance') }}
                    </a>
                </div>
            @endcan --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                                    id="daterange-btn" value="">
                                                <input type="hidden" name="start_date" id="start_date"
                                                    value="{{ $microFrom }}">
                                                <input type="hidden" name="end_date" id="end_date"
                                                    value="{{ $microTo }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="departement" id="departement"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Department
                                                </option>
                                                @foreach ($departments as $row)
                                                    <option value="{{ $row->id }}">{{ $row->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="is_present" id="is_present"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Is Present
                                                </option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="description" id="description"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Description
                                                </option>
                                                <option value="Tepat Waktu">Tepat Waktu</option>
                                                <option value="Terlambat">Terlambat</option>
                                                <option value="Izin">Izin</option>
                                                <option value="Sakit">Sakit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button id="btnExport" class="btn btn-success  mb-3">
                                                <i class='fas fa-file-excel'></i>
                                                {{ __('Export') }}
                                            </button>&nbsp;
                                            <button id="btnPdf" class="btn btn-danger  mb-3">
                                                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                                                {{ __('PDF') }}
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Departement') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Clock In') }}</th>
                                            <th>{{ __('Istirahat In') }}</th>
                                            <th>{{ __('Istirahat Out') }}</th>
                                            <th>{{ __('Clock Out') }}</th>
                                            <th>{{ __('Is Present') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Point') }}</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
    <link href="{{ asset('mazer/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('mazer/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mazer/js/daterangepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script>
        let columns = [{
                data: 'employee',
                name: 'employee.full_name'
            },
            {
                data: 'department_name',
                name: 'department_name',
            },
            {
                data: 'date',
                name: 'date',
            },
            {
                data: 'clock_in',
                name: 'clock_in',
            },
            {
                data: 'clock_istirahat',
                name: 'clock_istirahat',
            },
            {
                data: 'clock_istirahat_out',
                name: 'clock_istirahat_out',
            },
            {
                data: 'clock_out',
                name: 'clock_out',
            },
            {
                data: 'is_present',
                name: 'is_present',
            },
            {
                data: 'description',
                name: 'description',
            },
            {
                data: 'point',
                name: 'point',
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
                url: "{{ route('attendances.index') }}",
                data: function(s) {
                    s.start_date = $("#start_date").val();
                    s.end_date = $("#end_date").val();
                    s.departement = $('select[name=departement] option').filter(':selected').val()
                    s.is_present = $('select[name=is_present] option').filter(':selected').val()
                    s.description = $('select[name=description] option').filter(':selected').val()
                }
            },
            columns: columns
        });
        $('#departement').change(function() {
            table.draw();
        })

        $('#description').change(function() {
            table.draw();
        })

        $('#is_present').change(function() {
            table.draw();
        })

        $('#daterange-btn').change(function() {
            table.draw();
        })
    </script>

    <script>
        var start = {{ $microFrom }}
        var end = {{ $microTo }}
        var label = '';
        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'DD MMM YYYY'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')],
                }
            },
            function(start, end, label) {
                $('#start_date').val(Date.parse(start));
                $('#end_date').val(Date.parse(end));
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                }
            });

        function isDate(val) {
            var d = Date.parse(val);
            return Date.parse(val);
        }
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
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();

        });

        var exportData = function() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var departement = $('select[name=departement] option').filter(':selected').val()
            var is_present = $('select[name=is_present] option').filter(':selected').val()
            var description = $('select[name=description] option').filter(':selected').val()
            var url = '/export-data-atten/' + start_date + '/' + end_date + '/' + departement + '/' + is_present + '/' +
                description;
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    departement: departement,
                    is_present: is_present,
                    description: description,
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
                    var nameFile = 'Timesheet.xlsx'
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
        $(document).on('click', '#btnPdf', function(event) {
            event.preventDefault();
            cetakPdf();
        });
        var cetakPdf = function() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var departement = $('select[name=departement] option').filter(':selected').val()
            var is_present = $('select[name=is_present] option').filter(':selected').val()
            var description = $('select[name=description] option').filter(':selected').val()
            var url = '/pdf-atten/' + start_date + '/' + end_date + '/' + departement + '/' + is_present + '/' +
                description;


            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    departement: departement,
                    is_present: is_present,
                    description: description,
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
                    var nameFile = 'Timesheet.pdf'
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
