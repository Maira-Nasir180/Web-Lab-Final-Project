<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.orders', [
            'orders' => Order::with('items.product')->latest()->paginate(20),
        ]);
    }
}
