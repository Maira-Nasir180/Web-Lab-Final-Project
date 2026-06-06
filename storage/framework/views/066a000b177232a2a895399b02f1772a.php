<?php $__env->startSection('title', 'Admin — SweetBite'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
      <h1 class="h3 fw-bold mb-0">Admin dashboard</h1>
      <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary btn-sm">All orders</a>
    </div>

    <?php if(session('status')): ?>
      <div class="alert alert-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <h2 class="h5 fw-semibold mb-3">Products &amp; stock</h2>
    <div class="table-responsive shadow-sm rounded bg-white mb-5">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Product</th>
            <th colspan="3">Price, stock &amp; save</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="<?php echo e(asset('images/'.$product->image)); ?>" alt="" width="48" height="48" class="rounded" style="object-fit: cover;">
                  <span><?php echo e($product->name); ?></span>
                </div>
              </td>
              <td colspan="3">
                <form method="post" action="<?php echo e(route('admin.products.update', $product)); ?>" class="row row-cols-lg-auto g-2 align-items-end">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('PUT'); ?>
                  <div class="col-12 col-sm-auto">
                    <label class="form-label small mb-0" for="price-<?php echo e($product->id); ?>">Price</label>
                    <input type="number" id="price-<?php echo e($product->id); ?>" name="price" class="form-control form-control-sm" style="width: 110px;" min="0" value="<?php echo e($product->price); ?>" required>
                  </div>
                  <div class="col-12 col-sm-auto">
                    <label class="form-label small mb-0" for="stock-<?php echo e($product->id); ?>">Stock</label>
                    <input type="number" id="stock-<?php echo e($product->id); ?>" name="stock" class="form-control form-control-sm" style="width: 90px;" min="0" value="<?php echo e($product->stock); ?>" required>
                  </div>
                  <div class="col-12 col-sm-auto">
                    <button type="submit" class="btn btn-sm btn-order">Save</button>
                  </div>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>

    <h2 class="h5 fw-semibold mb-3">Recent orders</h2>
    <div class="table-responsive shadow-sm rounded bg-white">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($order->id); ?></td>
              <td>
                <div class="fw-semibold"><?php echo e($order->customer_name); ?></div>
                <div class="text-muted small"><?php echo e($order->customer_email); ?></div>
                <?php if($order->phone): ?>
                  <div class="text-muted small"><i class="bi bi-telephone me-1"></i><?php echo e($order->phone); ?></div>
                <?php endif; ?>
              </td>
              <td class="small">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo e($line->product->name); ?> × <?php echo e($line->quantity); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </td>
              <td class="text-muted small"><?php echo e($order->created_at->format('M j, H:i')); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="4" class="text-center text-muted py-4">No orders yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\sweetbite_bakery\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>