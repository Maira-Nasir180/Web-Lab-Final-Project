@extends('layouts.app')

@section('title', 'Admin — SweetBite')

@section('content')
  <div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
      <h1 class="h3 fw-bold mb-0">Admin dashboard</h1>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">All orders</a>
    </div>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-5">
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
          <div>
            <h2 class="h5 fw-semibold mb-1">
              <i class="bi bi-stars text-primary me-1"></i> Customer reviews summary
            </h2>
            <p class="text-muted small mb-0">Click the button when you want a summary of all customer feedback.</p>
          </div>
          <form method="post" action="{{ route('admin.reviews.summary.generate') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-order btn-sm">
              <i class="bi bi-magic me-1"></i> Give me review summary
            </button>
          </form>
        </div>

        @if ($reviewInsights)
          @php
            $sentimentBadge = match ($reviewInsights['sentiment'] ?? 'neutral') {
                'positive' => 'success',
                'negative' => 'danger',
                'mixed' => 'warning',
                default => 'secondary',
            };
          @endphp

          <div class="border-top pt-3">
            <div class="mb-2">
              <span class="badge text-bg-{{ $sentimentBadge }} text-capitalize">{{ $reviewInsights['sentiment'] }}</span>
            </div>

            <p class="mb-3">{{ $reviewInsights['summary'] }}</p>

            @if (! empty($reviewInsights['highlights']))
              <ul class="mb-3 ps-3">
                @foreach ($reviewInsights['highlights'] as $point)
                  <li class="small">{{ $point }}</li>
                @endforeach
              </ul>
            @endif

            <p class="text-muted small mb-0">
              Based on {{ $reviewInsights['review_count'] }} review(s).
              @if (! empty($reviewInsights['generated_at']))
                Generated {{ \Illuminate\Support\Carbon::parse($reviewInsights['generated_at'])->diffForHumans() }}.
              @endif
            </p>
          </div>
        @endif
      </div>
    </div>

    <h2 class="h5 fw-semibold mb-3">Products &amp; stock</h2>
    <div class="table-responsive shadow-sm rounded bg-white mb-5">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Product</th>
            <th colspan="3">Price, stock &amp; save</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ asset('images/'.$product->image) }}" alt="" width="48" height="48" class="rounded" style="object-fit: cover;">
                  <span>{{ $product->name }}</span>
                </div>
              </td>
              <td colspan="3">
                <form method="post" action="{{ route('admin.products.update', $product) }}" class="row row-cols-lg-auto g-2 align-items-end">
                  @csrf
                  @method('PUT')
                  <div class="col-12 col-sm-auto">
                    <label class="form-label small mb-0" for="price-{{ $product->id }}">Price</label>
                    <input type="number" id="price-{{ $product->id }}" name="price" class="form-control form-control-sm" style="width: 110px;" min="0" value="{{ $product->price }}" required>
                  </div>
                  <div class="col-12 col-sm-auto">
                    <label class="form-label small mb-0" for="stock-{{ $product->id }}">Stock</label>
                    <input type="number" id="stock-{{ $product->id }}" name="stock" class="form-control form-control-sm" style="width: 90px;" min="0" value="{{ $product->stock }}" required>
                  </div>
                  <div class="col-12 col-sm-auto">
                    <button type="submit" class="btn btn-sm btn-order">Save</button>
                  </div>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <h2 class="h5 fw-semibold mb-3">Recent orders</h2>
    <div class="table-responsive shadow-sm rounded bg-white">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($recentOrders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>
                <div class="fw-semibold">{{ $order->customer_name }}</div>
                <div class="text-muted small">{{ $order->customer_email }}</div>
                @if ($order->phone)
                  <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $order->phone }}</div>
                @endif
              </td>
              <td class="small">
                @foreach ($order->items as $line)
                  {{ $line->product->name }} × {{ $line->quantity }}@if(!$loop->last), @endif
                @endforeach
              </td>
              <td class="text-muted small">{{ $order->created_at->format('M j, H:i') }}</td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No orders yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
