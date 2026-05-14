<td>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('earning edit')): ?>
        <a href="<?php echo e(route('earnings.edit', $model->id)); ?>" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    <?php endif; ?>
</td>
<?php /**PATH D:\Project\Backend\hrm\resources\views/earnings/include/action.blade.php ENDPATH**/ ?>