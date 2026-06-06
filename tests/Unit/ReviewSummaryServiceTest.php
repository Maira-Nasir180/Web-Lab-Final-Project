<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Models\User;
use App\Services\ReviewSummaryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ReviewSummaryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_reviews_return_neutral_placeholder(): void
    {
        Cache::flush();

        $result = app(ReviewSummaryService::class)->generateForAdmin();

        $this->assertSame('empty', $result['source']);
        $this->assertSame(0, $result['review_count']);
        $this->assertSame('neutral', $result['sentiment']);
    }

    public function test_basic_summary_without_api_key(): void
    {
        config(['services.openai.key' => null]);
        Cache::flush();

        $user = User::factory()->create();
        Review::query()->create([
            'user_id' => $user->id,
            'body' => 'The chocolate cake was divine and absolutely delicious!',
        ]);

        $result = app(ReviewSummaryService::class)->generateForAdmin();

        $this->assertSame('basic', $result['source']);
        $this->assertSame(1, $result['review_count']);
        $this->assertSame('positive', $result['sentiment']);
        $this->assertNotEmpty($result['summary']);
    }
}
