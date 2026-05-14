<?php $__env->startSection('title', __('Monthlies')); ?>

<?php $__env->startSection('content'); ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Monthly Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('action-import-monthlies')); ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
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
                    <h3><?php echo e(__('Monthlies')); ?></h3>
                    <p class="text-subtitle text-muted">
                        <?php echo e(__('Below is a list of all monthlies.')); ?>

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
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Monthlies')); ?></li>
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

                                        <div class="col-md-3">
                                            <input type="month" id="month" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            
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
                                            <th><?php echo e(__('Employee')); ?></th>
                                            <th><?php echo e(__('Period')); ?></th>
                                            <th><?php echo e(__('Payroll Type')); ?></th>
                                            <th><?php echo e(__('Salary Monthly')); ?></th>
                                            <th><?php echo e(__('Salary Daily')); ?></th>
                                            <th><?php echo e(__('Total Earnings ')); ?></th>
                                            <th><?php echo e(__('Total Deductions')); ?></th>
                                            <th><?php echo e(__('Final Salary')); ?></th>
                                            <th><?php echo e(__('Is Send ?')); ?></th>
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

    <form action="/monthlies/generate" method="POST" id="form-generate-monthly">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="department_id" id="department_id">
        <input type="hidden" name="month_generate" id="month_generate">
    </form>
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
                url: "<?php echo e(route('monthlies.index')); ?>",
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
            var baseUrl = "<?php echo e(url('/slip')); ?>";
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\Backend\hrm\resources\views/monthlies/index.blade.php ENDPATH**/ ?>