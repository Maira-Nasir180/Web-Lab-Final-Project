<?php $__env->startSection('title', 'Reviews - SweetBite Bakery'); ?>

<?php $__env->startSection('content'); ?>
  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Customer reviews</h2>

      <?php if($errors->any()): ?>
        <div class="alert alert-danger col-md-8 mx-auto">
          <ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
      <?php endif; ?>

      <div class="row g-4 mb-5">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
              <p class="fst-italic mb-2"><?php echo e($review->body); ?></p>
              <h6 class="text-primary mb-0">– <?php echo e($review->user->name); ?></h6>
              <p class="text-muted small mb-0 mt-1"><?php echo e($review->created_at->format('M j, Y')); ?></p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-center text-muted">No reviews yet.</p>
        <?php endif; ?>
      </div>

      <div class="mt-2">
        <?php echo e($reviews->links()); ?>

      </div>

      <div class="mt-5">
        <h4 class="text-center fw-bold mb-3 text-secondary">Leave your review</h4>
        <?php if(auth()->guard()->check()): ?>
          <div class="col-md-8 mx-auto">
            <form method="post" action="<?php echo e(route('reviews.store')); ?>" class="p-4 shadow bg-white rounded">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <label class="form-label" for="review_body">Your review</label>
                <textarea id="review_body" name="body" class="form-control" rows="4" required minlength="10" maxlength="2000" placeholder="Tell others about your experience"><?php echo e(old('body')); ?></textarea>
                <div class="form-text">Posted as <?php echo e(auth()->user()->name); ?>. Minimum 10 characters.</div>
              </div>
              <button type="submit" class="btn btn-custom w-100">Submit review</button>
            </form>
          </div>
        <?php else: ?>
          <div class="col-md-8 mx-auto">
            <div class="alert alert-light border text-center mb-0">
              <p class="mb-2">You need an account to post a review.</p>
              <a href="<?php echo e(route('register')); ?>" class="btn btn-order btn-sm me-1">Register</a>
              <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary btn-sm">Sign in</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\x\htdocs\sweetbite_bakery\resources\views/reviews.blade.php ENDPATH**/ ?>