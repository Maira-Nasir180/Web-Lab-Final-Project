@extends('layouts.app')

@section('title', 'Reviews - SweetBite Bakery')

@section('content')
  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Customer reviews</h2>

      @if ($errors->any())
        <div class="alert alert-danger col-md-8 mx-auto">
          <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <div class="row g-4 mb-5">
        @forelse ($reviews as $review)
          <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
              <p class="fst-italic mb-2">{{ $review->body }}</p>
              <h6 class="text-primary mb-0">– {{ $review->user->name }}</h6>
              <p class="text-muted small mb-0 mt-1">{{ $review->created_at->format('M j, Y') }}</p>
            </div>
          </div>
        @empty
          <p class="text-center text-muted">No reviews yet.</p>
        @endforelse
      </div>

      <div class="mt-2">
        {{ $reviews->links() }}
      </div>

      <div class="mt-5">
        <h4 class="text-center fw-bold mb-3 text-secondary">Leave your review</h4>
        @auth
          <div class="col-md-8 mx-auto">
            <form method="post" action="{{ route('reviews.store') }}" class="p-4 shadow bg-white rounded">
              @csrf
              <div class="mb-3">
                <label class="form-label" for="review_body">Your review</label>
                <textarea id="review_body" name="body" class="form-control" rows="4" required minlength="10" maxlength="2000" placeholder="Tell others about your experience">{{ old('body') }}</textarea>
                <div class="form-text">Posted as {{ auth()->user()->name }}. Minimum 10 characters.</div>
              </div>
              <button type="submit" class="btn btn-custom w-100">Submit review</button>
            </form>
          </div>
        @else
          <div class="col-md-8 mx-auto">
            <div class="alert alert-light border text-center mb-0">
              <p class="mb-2">You need an account to post a review.</p>
              <a href="{{ route('register') }}" class="btn btn-order btn-sm me-1">Register</a>
              <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Sign in</a>
            </div>
          </div>
        @endauth
      </div>
    </div>
  </section>
@endsection
