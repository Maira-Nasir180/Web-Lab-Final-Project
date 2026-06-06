<?php $__env->startSection('title', 'Create customer account — SweetBite'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container py-5">
    <div class="col-md-6 mx-auto">
      <div class="text-center mb-3">
        <span class="badge rounded-pill text-bg-danger px-3 py-2">Customers only</span>
      </div>
      <h1 class="h3 fw-bold text-center mb-2">Create customer account</h1>
      <p class="text-center text-muted small mb-4">Use this page to shop online and leave reviews. Bakery staff do <strong>not</strong> register here — they use <a href="<?php echo e(route('admin.login')); ?>">Staff sign in</a> with an account created by the owner.</p>
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <?php if($errors->any()): ?>
            <div class="alert alert-danger small">
              <ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
          <?php endif; ?>
          <form method="post" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
              <label class="form-label" for="name">Full name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required minlength="8" autocomplete="new-password">
              <div class="form-text">At least 8 characters.</div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password_confirmation">Confirm password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-order w-100">Create account</button>
          </form>
          <p class="text-center small mt-3 mb-0">Already registered? <a href="<?php echo e(route('login')); ?>">Customer sign in</a></p>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\sweetbite_bakery\resources\views/auth/register.blade.php ENDPATH**/ ?>