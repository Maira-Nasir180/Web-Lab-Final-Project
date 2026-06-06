<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class BakeryController extends Controller
{
    public function home(): View
    {
        return view('home', ['active' => 'home']);
    }

    public function menu(): View
    {
        return view('menu', [
            'active' => 'menu',
            'items' => Product::active()->ordered()->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', ['active' => 'about']);
    }

    public function reviews(): View
    {
        return view('reviews', [
            'active' => 'reviews',
            'reviews' => Review::with('user')->latest()->paginate(12),
        ]);
    }

    public function contact(): View
    {
        return view('contact', ['active' => 'contact']);
    }
}
