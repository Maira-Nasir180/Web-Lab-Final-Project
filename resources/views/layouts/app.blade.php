<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SweetBite Bakery')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('head')
</head>
<body>
  @php
    $cartCount = 0;
    if (auth()->check() && ! auth()->user()->is_admin) {
        foreach (session('cart', []) as $q) {
            $cartCount += (int) $q;
        }
    }
  @endphp
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">SweetBite</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link {{ ($active ?? '') === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ ($active ?? '') === 'menu' ? 'active' : '' }}" href="{{ route('menu') }}">Menu</a></li>
          @auth
            @unless(auth()->user()->is_admin)
              <li class="nav-item">
                <a class="nav-link {{ in_array($active ?? '', ['cart', 'checkout'], true) ? 'active' : '' }}" href="{{ route('cart.index') }}">
                  Cart
                  @if ($cartCount > 0)
                    <span class="badge rounded-pill text-bg-danger">{{ $cartCount }}</span>
                  @endif
                </a>
              </li>
            @endunless
          @endauth
          <li class="nav-item"><a class="nav-link {{ ($active ?? '') === 'about' ? 'active' : '' }}" href="{{ route('about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link {{ ($active ?? '') === 'reviews' ? 'active' : '' }}" href="{{ route('reviews') }}">Reviews</a></li>
          <li class="nav-item"><a class="nav-link {{ ($active ?? '') === 'contact' ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
          @auth
            @if(auth()->user()->is_admin)
              <li class="nav-item"><a class="nav-link {{ str_starts_with(request()->path(), 'admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @endif
            <li class="nav-item">
              <form method="post" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link btn btn-link border-0 p-0 ms-lg-2" style="color: inherit;">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('login') }}">Customer sign in</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('register') }}">Register</a></li>
            <li class="nav-item"><a class="nav-link text-secondary small" href="{{ route('admin.login') }}"><i class="bi bi-shield-lock me-1"></i>Staff login</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  @if (session('status'))
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif

  @yield('content')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
