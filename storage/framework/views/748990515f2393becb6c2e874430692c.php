<?php $__env->startSection('title', 'Checkout — SweetBite'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container py-5 col-lg-8">
    <h1 class="h3 fw-bold mb-4">Checkout</h1>

    <?php if($errors->any()): ?>
      <div class="alert alert-danger">
        <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">
        <h2 class="h6 text-muted mb-3">Order summary</h2>
        <ul class="list-unstyled mb-0">
          <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="d-flex justify-content-between py-1 border-bottom">
              <span><?php echo e($row['product']->name); ?> × <?php echo e($row['qty']); ?></span>
              <span>PKR <?php echo e($row['line_total']); ?></span>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <li class="d-flex justify-content-between pt-3 fw-bold">
            <span>Total</span>
            <span>PKR <?php echo e($total); ?></span>
          </li>
        </ul>
      </div>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <p class="small text-muted mb-3">Ordering as <strong><?php echo e(auth()->user()->name); ?></strong> (<?php echo e(auth()->user()->email); ?>)</p>
        <form method="post" action="<?php echo e(route('checkout.store')); ?>">
          <?php echo csrf_field(); ?>
          <div class="mb-3">
            <label class="form-label" for="phone">Mobile number (11 digits)</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" required maxlength="11" pattern="[0-9]{11}" inputmode="numeric" autocomplete="tel" placeholder="03001234567">
            <div class="form-text">Pakistani format: exactly 11 digits only (no spaces or +).</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="address">Delivery address</label>
            <textarea class="form-control" id="address" name="address" rows="4" required placeholder="Street, area, city"><?php echo e(old('address')); ?></textarea>
          </div>
          <button type="submit" class="btn btn-order w-100">Place order</button>
        </form>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\x\htdocs\sweetbite_bakery\resources\views/checkout/index.blade.php ENDPATH**/ ?>