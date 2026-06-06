@extends('layouts.app')

@section('title', 'Staff sign in — SweetBite')

@section('content')
  <div class="container py-5">
    <div class="col-md-5 mx-auto">
      <div class="text-center mb-3">
        <span class="badge text-bg-dark px-3 py-2">Staff only</span>
      </div>
      <h1 class="h3 fw-bold text-center mb-2">Staff sign in</h1>
      <p class="text-center text-muted small mb-4">For bakery managers and admins. Customers should use <a href="{{ route('login') }}">Customer sign in</a> or <a href="{{ route('register') }}">Create account</a>.</p>
      <div class="card shadow-sm border-top border-3 border-secondary">
        <div class="card-body p-4">
          @if ($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
          @endif
          <form method="post" action="{{ url('/admin/login') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="email">Staff email</label>
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
            <button type="submit" class="btn btn-dark w-100">Sign in to admin</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
