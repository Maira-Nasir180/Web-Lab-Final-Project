<?php $__env->startSection('title', 'SweetBite Bakery | Menu'); ?>

<?php $__env->startSection('content'); ?>
  <header class="menu-header text-center py-5">
    <h1 class="fw-bold text-brown">Our Delicious Menu</h1>
    <p class="text-muted">Freshly baked with love and perfection every day</p>
  </header>

  <div class="container pb-5">
    <?php if($errors->has('cart')): ?>
      <div class="alert alert-danger text-center"><?php echo e($errors->first('cart')); ?></div>
    <?php endif; ?>

    <div class="row g-4">
      <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 col-sm-6">
          <div class="card h-100 shadow-sm border-0 <?php echo e($product->isInStock() ? '' : 'opacity-75'); ?>">
            <div class="position-relative">
              <img src="<?php echo e(asset('images/'.$product->image)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
              <?php if (! ($product->isInStock())): ?>
                <span class="sold-out-badge">Sold out</span>
              <?php endif; ?>
            </div>
            <div class="card-body text-center">
              <h5 class="card-title text-brown fw-semibold"><?php echo e($product->name); ?></h5>
              <p class="card-text text-muted">PKR <?php echo e($product->price); ?></p>
              <?php if($product->isInStock()): ?>
                <?php if(auth()->guard()->check()): ?>
                  <?php if (! (auth()->user()->is_admin)): ?>
                    <form method="post" action="<?php echo e(route('cart.add', $product)); ?>" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="qty" value="1">
                      <button type="submit" class="btn btn-order">Add to cart</button>
                    </form>
                  <?php else: ?>
                    <p class="small text-muted mb-0">Use the admin panel for stock.</p>
                  <?php endif; ?>
                <?php else: ?>
                  <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary">Sign in to order</a>
                  <p class="small text-muted mt-2 mb-0"><a href="<?php echo e(route('register')); ?>">Register</a> for a new account</p>
                <?php endif; ?>
              <?php else: ?>
                <button type="button" class="btn btn-secondary" disabled>Sold out</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\x\htdocs\sweetbite_bakery\resources\views/menu.blade.php ENDPATH**/ ?>