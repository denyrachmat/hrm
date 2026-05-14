<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(session('success')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Error')); ?></h4>
        <p><?php echo e(session('error')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('status') == 'profile-information-updated'): ?>
    <div class="alert alert-success alert-dismissible show fade mb-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(__('Profile information updated successfully.')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('status') == 'password-updated'): ?>
    <div class="alert alert-success alert-dismissible show fade mb-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(__('Password updated successfully.')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('status') == 'two-factor-authentication-disabled'): ?>
    <div class="alert alert-success alert-dismissible show fade mb-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(__('Two factor Authentication has been disabled.')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('status') == 'two-factor-authentication-enabled'): ?>
    <div class="alert alert-success alert-dismissible show fade mb-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(__('Two factor Authentication has been enabled.')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('status') == 'recovery-codes-generated'): ?>
    <div class="alert alert-success alert-dismissible show fade mb-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading"><?php echo e(__('Success')); ?></h4>
        <p><?php echo e(__('Regenerated Recovery Codes Successfully.')); ?></p>
    </div>
<?php endif; ?>
<?php /**PATH D:\Project\Backend\hrm\resources\views/components/alert.blade.php ENDPATH**/ ?>