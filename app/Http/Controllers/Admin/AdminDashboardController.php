<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'products' => Product::ordered()->get(),
            'recentOrders' => Order::with('items.product')->latest()->take(12)->get(),
            'reviewInsights' => session('review_insights'),
        ]);
    }
}
