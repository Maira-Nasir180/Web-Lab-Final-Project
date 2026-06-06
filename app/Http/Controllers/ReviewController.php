<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewSummaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        Review::create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        $reviewSummary = app(ReviewSummaryService::class);
        $reviewSummary->forgetCache();
        session()->forget('review_insights');

        return redirect()->route('reviews')->with('status', 'Thank you for your review!');
    }
}
