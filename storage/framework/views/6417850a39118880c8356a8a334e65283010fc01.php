<style>
    body {
        /* background-image: linear-gradient(120deg, #619dff 0%, #c2e9fb 100%); */
        /* background-image: linear-gradient(to top, #941A3C 0%, #EA493A 100%); */
        background-image: linear-gradient(to top, #EA493A 0%, #941A3C 100%);
        
    }

    .width-100 {
        width: 100px;
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="container m-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
            <div class="card-body shadow">
                <div class="text-center mb-3">
                    <img src="<?php echo e(asset('/images/vbe.png')); ?>" alt="" style="max-width: 40%;">
                </div>
                <form method="POST" class="m-0" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Code')); ?></label>

                        <div class="col-md-5">
                            <input id="code" type="text" class="form-control <?php if ($errors->has('code')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('code'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                name="code" value="<?php echo e(old('code')); ?>" required autocomplete="code" autofocus>

                            <?php if ($errors->has('code')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('code'); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

                        <div class="col-md-5">
                            <input id="password" type="password"
                                class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" required
                                autocomplete="current-password">

                            <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                <label class="form-check-label" for="remember">
                                    <?php echo e(__('Remember Me')); ?>

                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary width-100">
                                <?php echo e(__('Login')); ?>

                            </button>

                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<!-- เพิ่มส่วนของ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php if(session('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!',
        text: '<?php echo e(session('success')); ?>',
    });
</script>
<?php endif; ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\commission\resources\views/auth/login.blade.php ENDPATH**/ ?>