<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderPlacement
{
    /**
     * @param  array<int, array{product_id: int, qty: int}>  $items
     */
    public static function place(string $customerName, string $customerEmail, string $phone, string $address, array $items): Order
    {
        return DB::transaction(function () use ($customerName, $customerEmail, $phone, $address, $items) {
            $mergedQty = [];
            foreach ($items as $line) {
                $pid = (int) $line['product_id'];
                $mergedQty[$pid] = ($mergedQty[$pid] ?? 0) + (int) $line['qty'];
            }

            $lines = [];
            foreach ($mergedQty as $productId => $qty) {
                $product = Product::where('id', $productId)
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (! $product) {
                    throw ValidationException::withMessages([
                        'order' => 'One of the products is no longer available.',
                    ]);
                }

                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'order' => 'Not enough stock for '.$product->name.' (available: '.$product->stock.', requested: '.$qty.').',
                    ]);
                }

                $lines[] = ['product' => $product, 'qty' => $qty];
            }

            $order = Order::create([
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'phone' => $phone,
                'address' => $address,
            ]);

            foreach ($lines as $row) {
                $product = $row['product'];
                $qty = $row['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                ]);

                $product->decrement('stock', $qty);
            }

            return $order;
        });
    }
}
