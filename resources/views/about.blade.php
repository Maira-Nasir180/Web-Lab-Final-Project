@extends('layouts.app')

@section('title', 'About Us - SweetBite Bakery')

@section('content')
  <section class="about-section py-5">
    <div class="container">
      <div class="row align-items-start g-4">
        <div class="col-lg-5 col-md-6">
          <img src="{{ asset('images/bakery-hero.png') }}" class="img-fluid rounded shadow w-100" alt="Our Bakery">
        </div>
        <div class="col-lg-7 col-md-6 text-center text-md-start">
          <h2 class="fw-bold mb-4">About SweetBite Bakery</h2>
          <p class="lead mb-4 text-muted">
            SweetBite Bakery started with a simple dream — to spread joy through freshly baked delights.
            Every pastry, cake, and cookie we make is baked with love, passion, and the finest ingredients.
          </p>
          <h4 class="fw-semibold mt-4 mb-2">Our Story 🍪</h4>
          <p class="mb-3">
            Founded in 2020, SweetBite quickly became a local favorite for those who crave warmth and sweetness in every bite.
            We specialize in handcrafted cakes, pastries, cookies, and breads — all made daily in small batches to ensure freshness.
          </p>
          <h4 class="fw-semibold mb-2">Our Mission 🎯</h4>
          <p class="mb-0">To deliver happiness and create moments of joy with every sweet creation we serve.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
