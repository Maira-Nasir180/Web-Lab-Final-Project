<?php $__env->startSection('title', 'Contact Us - SweetBite Bakery'); ?>

<?php $__env->startSection('content'); ?>
  <section class="contact-section py-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Get in Touch</h2>
      <?php if(session('status')): ?>
        <div class="alert alert-success col-md-8 mx-auto text-center" role="alert">
          <?php echo e(session('status')); ?>

        </div>
      <?php endif; ?>
      <?php if($errors->any()): ?>
        <div class="alert alert-danger col-md-8 mx-auto">
          <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>
      <div class="row g-5 align-items-center">
        <div class="col-md-6">
          <form method="post" action="<?php echo e(route('contact.store')); ?>" class="p-4 rounded shadow bg-white">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
              <label class="form-label" for="contact_name">Full Name</label>
              <input type="text" class="form-control" id="contact_name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="contact_email">Email</label>
              <input type="email" class="form-control" id="contact_email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="contact_message">Message</label>
              <textarea class="form-control" id="contact_message" name="message" rows="4" placeholder="Write your message" required><?php echo e(old('message')); ?></textarea>
            </div>
            <button type="submit" class="btn btn-custom w-100">Send Message</button>
          </form>
        </div>
        <div class="col-md-6 text-center">
          <h4 class="fw-bold mb-3 text-danger">SweetBite Bakery</h4>
          <p><i class="bi bi-geo-alt-fill text-danger me-2"></i><strong>Address:</strong> 22 Bakery Street, Lahore, Pakistan</p>
          <p><i class="bi bi-telephone-fill text-success me-2"></i><strong>Phone:</strong> +92 312 5556789</p>
          <p><i class="bi bi-envelope-fill text-primary me-2"></i><strong>Email:</strong> sweetbitebakery@gmail.com</p>
          <div class="social-icons mt-4">
            <a href="#" class="me-3 text-decoration-none fs-4 text-primary" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="me-3 text-decoration-none fs-4 text-danger" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="mailto:sweetbitebakery@gmail.com" class="text-decoration-none fs-4 text-info" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\sweetbite_bakery\resources\views/contact.blade.php ENDPATH**/ ?>