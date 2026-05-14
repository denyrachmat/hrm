<td>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-gear"></i>
        </button>
        <ul class="dropdown-menu">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee view')): ?>
                <li>
                    <a href="<?php echo e(route('employees.show', $model->id)); ?>" class="dropdown-item">Detail</a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee edit')): ?>
                <li>
                    <a href="<?php echo e(route('employees.edit', $model->id)); ?>" class="dropdown-item">Edit</a>
                </li>
            <?php endif; ?>
            
            <li>
                <form action="<?php echo e(route('resetDevice', $model->id)); ?>" method="post" class="d-inline"
                    onsubmit="return confirm('Are you sure to Reset Device for this employee?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('delete'); ?>
                    <button class="dropdown-item">Reset Device</button>
                </form>
            </li>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee delete')): ?>
                <li>
                    <form action="<?php echo e(route('employees.destroy', $model->id)); ?>" method="post" class="d-inline"
                        onsubmit="return confirm('Are you sure to delete this record?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button style="color: red" class="dropdown-item"><i  class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                    </form>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</td>
<?php /**PATH D:\Project\Backend\hrm\resources\views/employees/include/action.blade.php ENDPATH**/ ?>