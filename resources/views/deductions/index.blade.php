@extends('layouts.app')

@section('title', __('Deductions'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Deductions') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all deductions.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Deductions') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            {{-- @can('deduction create')
                <div class="d-flex justify-content-end">
                    <button id="btnExport" class="btn btn-success  mb-3">
                        <i class='fas fa-file-excel'></i>
                        {{ __('Export') }}
                    </button>&nbsp;
                    <button type="button" class="btn btn-warning  mb-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                        Import
                    </button>
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
                                            <select name="departement" id="departement" class="form-control  js-example-basic-single">
                                                <option value="All">All Department
                                                </option>
                                                @foreach ($departement as $row)
                                                    <option value="{{ $row->id }}">{{ $row->department_name }}
                                                    </option>
                                                @endforeach
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
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th>{{ __('Total Deductions') }}</th>
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
    <script>
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                JSON.parse(d.deductions).map((e) => {
                    return `
                        <tr>
                            <td>${e.name}</td>
                            <td>:</td>
                            <td>${e.amount}</td>
                        </tr>
                    `
                })
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
                data: 'total',
                name: 'total',
                orderable: false,
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
                url: "{{ route('deductions.index') }}",
                data: function(s) {
                    s.departement = $('select[name=departement] option').filter(':selected').val()
                }
            },
            columns: columns
        });
        $('#departement').change(function() {
            table.draw();
        })
    </script>
@endpush
