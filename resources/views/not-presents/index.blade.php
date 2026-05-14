@extends('layouts.app')

@section('title', __('Not Presents'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Not Presents') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of employees who were not present during the selected period.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Not Presents') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="start_date">{{ __('Start Date') }}</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">{{ __('End Date') }}</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button class="btn btn-primary" id="filter">{{ __('Filter') }}</button>
                                </div>
                            </div>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">{{ __('Employee ID') }}</th>
                                        <th>{{ __('Full Name') }}</th>
                                        <th>{{ __('Department') }}</th>
                                        <th>{{ __('Branch') }}</th>
                                        <th width="10%">{{ __('Date') }}</th>
                                        <th width="10%">{{ __('Status') }}</th>
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
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css"/>
    <style>
        .badge-absent {
            background-color: #f44336;
            /* merah */
            color: white;
        }

        .badge-alpha {
            background-color: #ff9800;
            /* oranye */
            color: white;
        }

        .badge-izin {
            background-color: #2196f3;
            /* biru */
            color: white;
        }

        .badge-sakit {
            background-color: #9c27b0;
            /* ungu */
            color: white;
        }

        .badge-cuti {
            background-color: #4caf50;
            /* hijau */
            color: white;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>

    <script>
        $(function() {
            // Function to get today's date in local timezone (Asia/Jakarta)
            function getTodayLocalDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Function to get URL parameters
            function getUrlParams() {
                const urlSearchParams = new URLSearchParams(window.location.search);
                const params = Object.fromEntries(urlSearchParams.entries());
                return params;
            }

            const urlParams = getUrlParams();
            const startDateParam = urlParams.start_date;
            const endDateParam = urlParams.end_date;

            // Set date inputs based on URL parameters or default to today (local timezone)
            $('#start_date').val(startDateParam ? startDateParam : getTodayLocalDate());
            $('#end_date').val(endDateParam ? endDateParam : getTodayLocalDate());

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('not-presents.index') }}",
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                pageLength: 100,
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta) {
                            var badgeClass = '';

                            switch (data.toLowerCase()) {
                                case 'alpha':
                                    badgeClass = 'badge-alpha';
                                    break;
                                case 'izin':
                                    badgeClass = 'badge-izin';
                                    break;
                                case 'sakit':
                                    badgeClass = 'badge-sakit';
                                    break;
                                case 'cuti':
                                    badgeClass = 'badge-cuti';
                                    break;
                                case 'absent':
                                default:
                                    badgeClass = 'badge-absent';
                            }

                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    }
                ],
                order: [
                    [5, 'asc'],
                    [2, 'asc']
                ]
            });

            $('#filter').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                // Update URL with filter parameters
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('start_date', startDate);
                newUrl.searchParams.set('end_date', endDate);
                window.history.pushState({}, '', newUrl);

                table.ajax.reload();
            });

            // Validate date range
            $('#start_date, #end_date').change(function() {
                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());

                if (startDate > endDate) {
                    alert('End date must be greater than or equal to start date');
                    $(this).val('');
                }
            });
        });
    </script>
@endpush
