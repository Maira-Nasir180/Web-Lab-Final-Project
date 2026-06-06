@extends('layouts.app')

@section('title', 'Orders — Admin')

@section('content')
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 fw-bold mb-0">All orders</h1>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
    </div>
    <div class="table-responsive shadow-sm rounded bg-white">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Items</th>
            <th>Total</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
            @php
              $total = $order->items->sum(fn ($i) => $i->quantity * $i->unit_price);
            @endphp
            <tr>
              <td>{{ $order->id }}</td>
              <td>
                <div class="fw-semibold">{{ $order->customer_name }}</div>
                <div class="text-muted small">{{ $order->customer_email }}</div>
              </td>
              <td class="small">{{ $order->phone ?? '—' }}</td>
              <td class="small" style="max-width: 200px;">{{ $order->address }}</td>
              <td class="small">
                <ul class="mb-0 ps-3">
                  @foreach ($order->items as $line)
                    <li>{{ $line->product->name }} × {{ $line->quantity }} @ PKR {{ $line->unit_price }}</li>
                  @endforeach
                </ul>
              </td>
              <td class="fw-semibold">PKR {{ $total }}</td>
              <td class="text-muted small">{{ $order->created_at->format('M j, Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
  </div>
@endsection
