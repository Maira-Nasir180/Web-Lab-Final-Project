<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $ids = array_keys($cart);
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

        return view('cart.index', [
            'active' => 'cart',
            'lines' => $lines,
            'total' => $total,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'qty' => ['nullable', 'integer', 'min:1', 'max:500'],
        ]);

        $qty = (int) ($request->input('qty', 1));
        if (! $product->is_active || ! $product->isInStock()) {
            return back()->withErrors(['cart' => 'This product is not available.']);
        }

        $cart = session('cart', []);
        $key = (string) $product->id;
        $current = (int) ($cart[$key] ?? 0);

        if ($current + $qty > $product->stock) {
            return back()->withErrors(['cart' => 'You cannot add more than available stock ('.$product->stock.').']);
        }

        $cart[$key] = $current + $qty;
        session(['cart' => $cart]);

        return back()->with('status', $product->name.' added to your cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'qty' => ['required', 'integer', 'min:0', 'max:500'],
        ]);

        $qty = (int) $request->input('qty');
        $cart = session('cart', []);
        $key = (string) $product->id;

        if ($qty === 0) {
            unset($cart[$key]);
            session(['cart' => $cart]);

            return redirect()->route('cart.index')->with('status', 'Item removed from cart.');
        }

        if (! $product->is_active || ! $product->isInStock()) {
            unset($cart[$key]);
            session(['cart' => $cart]);

            return redirect()->route('cart.index')->withErrors(['cart' => 'A product in your cart is no longer available and was removed.']);
        }

        if ($qty > $product->stock) {
            return back()->withErrors(['cart' => 'Maximum available for '.$product->name.' is '.$product->stock.'.']);
        }

        $cart[$key] = $qty;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Cart updated.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[(string) $product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Item removed.');
    }
}
