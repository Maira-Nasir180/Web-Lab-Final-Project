@extends('layouts.app')

@section('title', 'Create customer account — SweetBite')

@section('content')
  <div class="container py-5">
    <div class="col-md-6 mx-auto">
      <div class="text-center mb-3">
        <span class="badge rounded-pill text-bg-danger px-3 py-2">Customers only</span>
      </div>
      <h1 class="h3 fw-bold text-center mb-2">Create customer account</h1>
      <p class="text-center text-muted small mb-4">Use this page to shop online and leave reviews. Bakery staff do <strong>not</strong> register here — they use <a href="{{ route('admin.login') }}">Staff sign in</a> with an account created by the owner.</p>
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          @if ($errors->any())
            <div class="alert alert-danger small">
              <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif
          <form method="post" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="name">Full name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required minlength="8" autocomplete="new-password">
              <div class="form-text">At least 8 characters.</div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password_confirmation">Confirm password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-order w-100">Create account</button>
          </form>
          <p class="text-center small mt-3 mb-0">Already registered? <a href="{{ route('login') }}">Customer sign in</a></p>
        </div>
      </div>
    </div>
  </div>
@endsection
