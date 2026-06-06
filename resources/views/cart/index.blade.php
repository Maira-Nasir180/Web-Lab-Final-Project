@extends('layouts.app')

@section('title', 'Your cart — SweetBite')

@section('content')
  <div class="container py-5">
    <h1 class="h3 fw-bold mb-4">Your cart</h1>

    @if ($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if ($lines === [])
      <p class="text-muted">Your cart is empty. <a href="{{ route('menu') }}">Browse the menu</a>.</p>
    @else
      <div class="table-responsive shadow-sm rounded bg-white mb-4">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Item</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lines as $row)
              @php $p = $row['product']; @endphp
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/'.$p->image) }}" alt="" width="44" height="44" class="rounded" style="object-fit: cover;">
                    <span class="fw-semibold">{{ $p->name }}</span>
                  </div>
                </td>
                <td>PKR {{ $p->price }}</td>
                <td style="min-width: 140px;">
                  <form method="post" action="{{ route('cart.update', $p) }}" class="d-flex gap-1 align-items-center">
                    @csrf
                    @method('PUT')
                    <input type="number" name="qty" class="form-control form-control-sm" value="{{ $row['qty'] }}" min="0" max="500" style="width: 72px;">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                  </form>
                </td>
                <td class="fw-semibold">PKR {{ $row['line_total'] }}</td>
                <td>
                  <form method="post" action="{{ route('cart.remove', $p) }}" onsubmit="return confirm('Remove this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="table-light">
            <tr>
              <th colspan="3" class="text-end">Total</th>
              <th colspan="2">PKR {{ $total }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('menu') }}" class="btn btn-outline-secondary">Continue shopping</a>
        <a href="{{ route('checkout.index') }}" class="btn btn-order">Checkout</a>
      </div>
    @endif
  </div>
@endsection
