@extends('layouts.app')

@section('title', 'Contact Us - SweetBite Bakery')

@section('content')
  <section class="contact-section py-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Get in Touch</h2>
      @if (session('status'))
        <div class="alert alert-success col-md-8 mx-auto text-center" role="alert">
          {{ session('status') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger col-md-8 mx-auto">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="row g-5 align-items-center">
        <div class="col-md-6">
          <form method="post" action="{{ route('contact.store') }}" class="p-4 rounded shadow bg-white">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="contact_name">Full Name</label>
              <input type="text" class="form-control" id="contact_name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="contact_email">Email</label>
              <input type="email" class="form-control" id="contact_email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="contact_message">Message</label>
              <textarea class="form-control" id="contact_message" name="message" rows="4" placeholder="Write your message" required>{{ old('message') }}</textarea>
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
@endsection
