@extends('layouts.app')

@section('title', 'SweetBite Bakery | Menu')

@section('content')
  <header class="menu-header text-center py-5">
    <h1 class="fw-bold text-brown">Our Delicious Menu</h1>
    <p class="text-muted">Freshly baked with love and perfection every day</p>
  </header>

  <div class="container pb-5">
    @if ($errors->has('cart'))
      <div class="alert alert-danger text-center">{{ $errors->first('cart') }}</div>
    @endif

    <div class="row g-4">
      @foreach ($items as $product)
        <div class="col-md-4 col-sm-6">
          <div class="card h-100 shadow-sm border-0 {{ $product->isInStock() ? '' : 'opacity-75' }}">
            <div class="position-relative">
              <img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
              @unless ($product->isInStock())
                <span class="sold-out-badge">Sold out</span>
              @endunless
            </div>
            <div class="card-body text-center">
              <h5 class="card-title text-brown fw-semibold">{{ $product->name }}</h5>
              <p class="card-text text-muted">PKR {{ $product->price }}</p>
              @if ($product->isInStock())
                @auth
                  @unless(auth()->user()->is_admin)
                    <form method="post" action="{{ route('cart.add', $product) }}" class="d-inline">
                      @csrf
                      <input type="hidden" name="qty" value="1">
                      <button type="submit" class="btn btn-order">Add to cart</button>
                    </form>
                  @else
                    <p class="small text-muted mb-0">Use the admin panel for stock.</p>
                  @endunless
                @else
                  <a href="{{ route('login') }}" class="btn btn-outline-secondary">Sign in to order</a>
                  <p class="small text-muted mt-2 mb-0"><a href="{{ route('register') }}">Register</a> for a new account</p>
                @endauth
              @else
                <button type="button" class="btn btn-secondary" disabled>Sold out</button>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
