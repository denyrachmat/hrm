<!DOCTYPE html>
<html lang="en">
<?php
    $a = getCompany();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Jaya Abadi Teknik - <?php echo $__env->yieldContent('title'); ?>  </title>
    <link rel="stylesheet" href="<?php echo e(asset('mazer')); ?>/css/main/app.css">
    <link rel="stylesheet" href="<?php echo e(asset('mazer')); ?>/css/main/app-dark.css">
    <link rel="stylesheet" href="<?php echo e(asset('mazer')); ?>/css/shared/iconly.css">
    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body>
    <div id="app">
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
<?php /**PATH D:\Project\Backend\hrm\resources\views/layouts/header.blade.php ENDPATH**/ ?>