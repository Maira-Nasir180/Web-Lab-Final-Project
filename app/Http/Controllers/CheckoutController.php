<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderPlacement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $ids = array_keys($cart);
        if (empty($ids) || empty(array_filter($cart))) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $products = Product::whereIn('id', $ids)->get()->keyBy('id');
        $lines = [];
        $total = 0;
        foreach ($cart as $productId => $qty) {
            $qty = (int) $qty;
            if ($qty < 1) {
                continue;
            }
            $product = $products->get((int) $productId);
            if (! $product) {
                continue;
            }
            $lineTotal = $product->price * $qty;
            $total += $lineTotal;
            $lines[] = [
                'product' => $product,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        if ($lines === []) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        return view('checkout.index', [
            'active' => 'checkout',
            'lines' => $lines,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'digits:11'],
            'address' => ['required', 'string', 'max:2000'],
        ], [
            'phone.digits' => 'Phone must be exactly 11 digits (no spaces or symbols), e.g. 03001234567.',
        ]);

        $cart = session('cart', []);
        $items = [];
        foreach ($cart as $productId => $qty) {
            $qty = (int) $qty;
            if ($qty > 0) {
                $items[] = ['product_id' => (int) $productId, 'qty' => $qty];
            }
        }

        if ($items === []) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $user = Auth::user();

        try {
            OrderPlacement::place(
                $user->name,
                $user->email,
                $request->input('phone'),
                $request->input('address'),
                $items
            );
        } catch (ValidationException $e) {
            return redirect()->route('cart.index')->withErrors($e->errors());
        }

        session()->forget('cart');

        return redirect()->route('home')->with('status', 'Your order was placed. Thank you!');
    }
}
