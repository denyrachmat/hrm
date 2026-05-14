<?php $__env->startSection('title', __('Employees')); ?>

<?php $__env->startSection('content'); ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('action-import-employees')); ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
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
                    <h3><?php echo e(__('Employees')); ?></h3>
                    <p class="text-subtitle text-muted">
                        <?php echo e(__('Below is a list of all employees.')); ?>

                    </p>
                </div>
                <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <li class="breadcrumb-item"><a href="/"><?php echo e(__('Dashboard')); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Employees')); ?></li>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
            </div>
        </div>

        <section class="section">
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee create')): ?>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        <?php echo e(__('Create a new employee')); ?>

                    </a>&nbsp;
                    <button id="btnPdf" class="btn btn-danger  mb-3">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <?php echo e(__('PDF')); ?>

                    </button>&nbsp;
                    <button id="btnExport" class="btn btn-success  mb-3">
                        <i class='fas fa-file-excel'></i>
                        <?php echo e(__('Export')); ?>

                    </button>&nbsp;
                    <button type="button" class="btn btn-warning  mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                        Import
                    </button>
                </div>
            <?php endif; ?>

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
                                                <?php $__currentLoopData = $departement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($row->id); ?>"><?php echo e($row->department_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <th><?php echo e(__('Employee Id')); ?></th>
                                            <th><?php echo e(__('Full Name')); ?></th>
                                            <th><?php echo e(__('Department')); ?></th>
                                            <th><?php echo e(__('Work Status')); ?></th>
                                            <th><?php echo e(__('Use GPS Location')); ?></th>
                                            <th><?php echo e(__('Start Contract Date')); ?></th>
                                            <th><?php echo e(__('End Contract Date')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
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
                url: "<?php echo e(route('employees.index')); ?>",
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\Backend\hrm\resources\views/employees/index.blade.php ENDPATH**/ ?>