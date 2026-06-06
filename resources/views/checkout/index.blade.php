@extends('layouts.app')

@section('title', 'Checkout — SweetBite')

@section('content')
  <div class="container py-5 col-lg-8">
    <h1 class="h3 fw-bold mb-4">Checkout</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">
        <h2 class="h6 text-muted mb-3">Order summary</h2>
        <ul class="list-unstyled mb-0">
          @foreach ($lines as $row)
            <li class="d-flex justify-content-between py-1 border-bottom">
              <span>{{ $row['product']->name }} × {{ $row['qty'] }}</span>
              <span>PKR {{ $row['line_total'] }}</span>
            </li>
          @endforeach
          <li class="d-flex justify-content-between pt-3 fw-bold">
            <span>Total</span>
            <span>PKR {{ $total }}</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <p class="small text-muted mb-3">Ordering as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})</p>
        <form method="post" action="{{ route('checkout.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="phone">Mobile number (11 digits)</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required maxlength="11" pattern="[0-9]{11}" inputmode="numeric" autocomplete="tel" placeholder="03001234567">
            <div class="form-text">Pakistani format: exactly 11 digits only (no spaces or +).</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="address">Delivery address</label>
            <textarea class="form-control" id="address" name="address" rows="4" required placeholder="Street, area, city">{{ old('address') }}</textarea>
          </div>
          <button type="submit" class="btn btn-order w-100">Place order</button>
        </form>
      </div>
    </div>
  </div>
@endsection
