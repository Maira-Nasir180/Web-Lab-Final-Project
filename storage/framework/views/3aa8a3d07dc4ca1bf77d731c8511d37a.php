<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo $__env->yieldContent('title', 'SweetBite Bakery'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>
  <?php
    $cartCount = 0;
    if (auth()->check() && ! auth()->user()->is_admin) {
        foreach (session('cart', []) as $q) {
            $cartCount += (int) $q;
        }
    }
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="<?php echo e(route('home')); ?>">SweetBite</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link <?php echo e(($active ?? '') === 'home' ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(($active ?? '') === 'menu' ? 'active' : ''); ?>" href="<?php echo e(route('menu')); ?>">Menu</a></li>
          <?php if(auth()->guard()->check()): ?>
            <?php if (! (auth()->user()->is_admin)): ?>
              <li class="nav-item">
                <a class="nav-link <?php echo e(in_array($active ?? '', ['cart', 'checkout'], true) ? 'active' : ''); ?>" href="<?php echo e(route('cart.index')); ?>">
                  Cart
                  <?php if($cartCount > 0): ?>
                    <span class="badge rounded-pill text-bg-danger"><?php echo e($cartCount); ?></span>
                  <?php endif; ?>
                </a>
              </li>
            <?php endif; ?>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link <?php echo e(($active ?? '') === 'about' ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">About Us</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(($active ?? '') === 'reviews' ? 'active' : ''); ?>" href="<?php echo e(route('reviews')); ?>">Reviews</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(($active ?? '') === 'contact' ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact</a></li>
          <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->is_admin): ?>
              <li class="nav-item"><a class="nav-link <?php echo e(str_starts_with(request()->path(), 'admin') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <?php endif; ?>
            <li class="nav-item">
              <form method="post" action="<?php echo e(route('logout')); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-link btn btn-link border-0 p-0 ms-lg-2" style="color: inherit;">Logout</button>
              </form>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link fw-semibold" href="<?php echo e(route('login')); ?>">Customer sign in</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="<?php echo e(route('register')); ?>">Register</a></li>
            <li class="nav-item"><a class="nav-link text-secondary small" href="<?php echo e(route('admin.login')); ?>"><i class="bi bi-shield-lock me-1"></i>Staff login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php if(session('status')): ?>
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <?php echo e(session('status')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>

  <?php echo $__env->yieldContent('content'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\sweetbite_bakery\resources\views/layouts/app.blade.php ENDPATH**/ ?>