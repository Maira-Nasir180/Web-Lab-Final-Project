<?php $__env->startSection('title', 'Staff sign in — SweetBite'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container py-5">
    <div class="col-md-5 mx-auto">
      <div class="text-center mb-3">
        <span class="badge text-bg-dark px-3 py-2">Staff only</span>
      </div>
      <h1 class="h3 fw-bold text-center mb-2">Staff sign in</h1>
      <p class="text-center text-muted small mb-4">For bakery managers and admins. Customers should use <a href="<?php echo e(route('login')); ?>">Customer sign in</a> or <a href="<?php echo e(route('register')); ?>">Create account</a>.</p>
      <div class="card shadow-sm border-top border-3 border-secondary">
        <div class="card-body p-4">
          <?php if($errors->any()): ?>
            <div class="alert alert-danger small"><?php echo e($errors->first()); ?></div>
          <?php endif; ?>
          <form method="post" action="<?php echo e(url('/admin/login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
              <label class="form-label" for="email">Staff email</label>
              <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-dark w-100">Sign in to admin</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\x\htdocs\sweetbite_bakery\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>