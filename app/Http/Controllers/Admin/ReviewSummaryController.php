<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReviewSummaryService;
use Illuminate\Http\RedirectResponse;

class ReviewSummaryController extends Controller
{
    public function generate(ReviewSummaryService $reviewSummary): RedirectResponse
    {
        session(['review_insights' => $reviewSummary->generateForAdmin()]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Review summary is ready.');
    }
}
