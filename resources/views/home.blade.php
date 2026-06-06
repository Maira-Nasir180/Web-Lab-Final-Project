@extends('layouts.app')

@section('title', 'SweetBite Bakery')

@section('content')
  <section id="home" class="hero-section d-flex align-items-center text-center text-white">
    <div class="overlay"></div>
    <div class="container position-relative">
      <h1 class="display-3 fw-bold mb-3 animate-fade text-white">Freshly Baked Happiness Everyday</h1>
      <p class="lead mb-4 animate-fade-delay">Experience the taste of love, warmth, and sweetness at SweetBite Bakery.</p>
      <a href="{{ route('menu') }}" class="btn btn-lg btn-custom shadow-lg">Explore Menu</a>
    </div>
  </section>
@endsection
