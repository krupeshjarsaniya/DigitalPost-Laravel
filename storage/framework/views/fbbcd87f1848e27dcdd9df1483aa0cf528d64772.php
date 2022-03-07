<!DOCTYPE html>

<html lang="en">



<?php $__env->startSection('content'); ?>

<style type="text/css">
    #myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
}
</style>
<body class="login" >
    <link rel="icon" type="image/png" href="<?php echo e(asset('public/images/favicon1.png')); ?>"/>
    <div class="wrapper wrapper-login wrapper-login-full p-0" >

        

        <div class="login-aside w-100 d-flex align-items-center justify-content-center   " style="">

            <div class="container container-login container-transparent animated fadeIn " style="background-color: #fff;box-shadow: -1px 3px 3px 3px #ccc;"   >

                <h3 class="text-center theme-font-color">Sign In To Admin</h3>

                 <form method="POST" name="loginForm" onsubmit="return false" aria-label="<?php echo e(__('Register')); ?>">

                    <?php echo csrf_field(); ?>

                    <div class="login-form">

                       <div class="form-group err_email">

                            <label for="email2">Email Address</label>

                            <input type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus id="email2" placeholder="Enter Email">

                        </div>

                        <div class="form-group err_password">

                            <label for="password" class="placeholder"><b>Password</b></label>

                            <div class="position-relative">

                                <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required id="password" placeholder="Password">

                            </div>

                        </div>

                        <div class="form-group form-action-d-flex mb-3">

                            <div class="custom-control custom-checkbox">

                                <input type="checkbox" class="custom-control-input" id="rememberme">

                                <label class="custom-control-label m-0" for="rememberme">Remember Me</label>

                            </div>

                            <input type="button" onclick="login()" class="btn btn-secondary" value="Login" name="submit">

                        </div>

                    </div>

                 </form>

            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/public/admin/js/login.js')); ?>"></script>
<?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/digital-post/resources/views/auth/login.blade.php ENDPATH**/ ?>