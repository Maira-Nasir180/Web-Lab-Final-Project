@extends('layouts.app')

@section('title', 'Customer sign in — SweetBite')

@section('content')
  <div class="container py-5">
    <div class="col-md-5 mx-auto">
      <div class="text-center mb-3">
        <span class="badge rounded-pill text-bg-danger px-3 py-2">Customers</span>
      </div>
      <h1 class="h3 fw-bold text-center mb-2">Customer sign in</h1>
      <p class="text-center text-muted small mb-4">Sign in to add items to your cart, checkout, and write reviews. Ordering an account is separate from staff access.</p>
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          @if ($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
          @endif
          @if (session('staff_login_url'))
            <div class="alert alert-info small py-2">
              <a href="{{ session('staff_login_url') }}" class="alert-link fw-semibold">Go to Staff sign in</a> if you manage the bakery.
            </div>
          @endif
          <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-order w-100">Sign in</button>
          </form>
          <p class="text-center small mt-3 mb-0">New customer? <a href="{{ route('register') }}">Create an account</a></p>
          <hr class="my-3">
          <p class="text-center small text-muted mb-0">Work at SweetBite? Use <a href="{{ route('admin.login') }}" class="fw-semibold">Staff sign in</a> (different page).</p>
        </div>
      </div>
    </div>
  </div>
@endsection
