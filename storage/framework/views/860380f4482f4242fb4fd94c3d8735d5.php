<?php $__env->startSection('title', 'Orders — Admin'); ?>

<?php $__env->startSection('content'); ?>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 fw-bold mb-0">All orders</h1>
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">Dashboard</a>
    </div>
    <div class="table-responsive shadow-sm rounded bg-white">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Items</th>
            <th>Total</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $total = $order->items->sum(fn ($i) => $i->quantity * $i->unit_price);
            ?>
            <tr>
              <td><?php echo e($order->id); ?></td>
              <td>
                <div class="fw-semibold"><?php echo e($order->customer_name); ?></div>
                <div class="text-muted small"><?php echo e($order->customer_email); ?></div>
              </td>
              <td class="small"><?php echo e($order->phone ?? '—'); ?></td>
              <td class="small" style="max-width: 200px;"><?php echo e($order->address); ?></td>
              <td class="small">
                <ul class="mb-0 ps-3">
                  <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($line->product->name); ?> × <?php echo e($line->quantity); ?> @ PKR <?php echo e($line->unit_price); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </td>
              <td class="fw-semibold">PKR <?php echo e($total); ?></td>
              <td class="text-muted small"><?php echo e($order->created_at->format('M j, Y H:i')); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
    <div class="mt-3"><?php echo e($orders->links()); ?></div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\x\htdocs\sweetbite_bakery\resources\views/admin/orders.blade.php ENDPATH**/ ?>