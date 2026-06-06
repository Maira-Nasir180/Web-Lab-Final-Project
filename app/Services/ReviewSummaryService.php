<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReviewSummaryService
{
    public const CACHE_KEY = 'admin.review_summary';

    private const POSITIVE_WORDS = [
        'love', 'loved', 'best', 'great', 'excellent', 'amazing', 'perfect', 'delicious',
        'wonderful', 'fantastic', 'divine', 'irresistible', 'fresh', 'moist', 'rich',
    ];

    private const NEGATIVE_WORDS = [
        'bad', 'worst', 'terrible', 'awful', 'disappointing', 'stale', 'dry', 'rude',
        'slow', 'cold', 'overpriced', 'never', 'hate', 'poor',
    ];

    /**
     * @return array{
     *     summary: string,
     *     sentiment: string,
     *     highlights: list<string>,
     *     source: string,
     *     review_count: int,
     *     generated_at: string,
     * }
     */
    public function generateForAdmin(): array
    {
        $result = $this->buildSummary();

        Cache::put(self::CACHE_KEY, $result, now()->addHours(6));

        return $result;
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return array{
     *     summary: string,
     *     sentiment: string,
     *     highlights: list<string>,
     *     source: string,
     *     review_count: int,
     *     generated_at: string
     * }
     */
    private function buildSummary(): array
    {
        $reviews = Review::query()
            ->with('user:id,name')
            ->latest()
            ->get();

        if ($reviews->isEmpty()) {
            return $this->payload(
                summary: 'No customer reviews yet. Insights will appear here once shoppers leave feedback.',
                sentiment: 'neutral',
                highlights: [],
                source: 'empty',
                reviewCount: 0,
            );
        }

        $apiKey = config('services.openai.key');

        if (filled($apiKey)) {
            try {
                return $this->summarizeWithAi($reviews, $apiKey);
            } catch (\Throwable $e) {
                Log::warning('Review AI summary failed, using basic fallback.', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return $this->summarizeBasic($reviews);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Review>  $reviews
     * @return array{
     *     summary: string,
     *     sentiment: string,
     *     highlights: list<string>,
     *     source: string,
     *     review_count: int,
     *     generated_at: string
     * }
     */
    private function summarizeWithAi($reviews, string $apiKey): array
    {
        $lines = $reviews->map(function (Review $review) {
            $name = $review->user?->name ?? 'Customer';

            return sprintf('- %s (%s): %s', $name, $review->created_at->format('Y-m-d'), $review->body);
        })->implode("\n");

        $response = Http::withToken($apiKey)
            ->timeout(45)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'temperature' => 0.3,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You summarize bakery customer reviews for a shop admin. Reply only with valid JSON using keys: summary (2-4 sentences), sentiment (positive|mixed|negative|neutral), highlights (array of 2-5 short bullet strings about themes, praise, or concerns). Be factual and concise.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Summarize these {$reviews->count()} SweetBite Bakery reviews for the admin:\n\n{$lines}",
                    ],
                ],
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException($response->json('error.message') ?? $response->body());
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($content) || $content === '') {
            throw new \RuntimeException('Empty response from AI provider.');
        }

        /** @var array<string, mixed>|null $parsed */
        $parsed = json_decode($content, true);

        if (! is_array($parsed)) {
            throw new \RuntimeException('AI response was not valid JSON.');
        }

        $summary = trim((string) ($parsed['summary'] ?? ''));
        $sentiment = $this->normalizeSentiment((string) ($parsed['sentiment'] ?? 'neutral'));
        $highlights = $this->normalizeHighlights($parsed['highlights'] ?? []);

        if ($summary === '') {
            throw new \RuntimeException('AI summary text was missing.');
        }

        return $this->payload(
            summary: $summary,
            sentiment: $sentiment,
            highlights: $highlights,
            source: 'ai',
            reviewCount: $reviews->count(),
        );
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Review>  $reviews
     * @return array{
     *     summary: string,
     *     sentiment: string,
     *     highlights: list<string>,
     *     source: string,
     *     review_count: int,
     *     generated_at: string
     * }
     */
    private function summarizeBasic($reviews): array
    {
        $text = Str::lower($reviews->pluck('body')->implode(' '));

        $positive = 0;
        $negative = 0;

        foreach (self::POSITIVE_WORDS as $word) {
            $positive += substr_count($text, $word);
        }

        foreach (self::NEGATIVE_WORDS as $word) {
            $negative += substr_count($text, $word);
        }

        $sentiment = match (true) {
            $positive > $negative && $negative === 0 => 'positive',
            $negative > $positive && $positive === 0 => 'negative',
            $positive > 0 && $negative > 0 => 'mixed',
            $positive > $negative => 'positive',
            $negative > $positive => 'negative',
            default => 'neutral',
        };

        $highlights = $reviews
            ->take(3)
            ->map(fn (Review $review) => Str::limit($review->body, 90))
            ->values()
            ->all();

        $summary = match ($sentiment) {
            'positive' => "Customers left {$reviews->count()} review(s) with mostly positive feedback. Recent comments praise quality and taste.",
            'negative' => "Across {$reviews->count()} review(s), wording suggests some dissatisfaction. Check recent comments for recurring issues.",
            'mixed' => "From {$reviews->count()} review(s), feedback looks mixed—some praise and some concerns appear in recent posts.",
            default => "There are {$reviews->count()} review(s). Read the latest comments below for detail.",
        };

        return $this->payload(
            summary: $summary,
            sentiment: $sentiment,
            highlights: $highlights,
            source: 'basic',
            reviewCount: $reviews->count(),
        );
    }

    /**
     * @param  mixed  $highlights
     * @return list<string>
     */
    private function normalizeHighlights(mixed $highlights): array
    {
        if (! is_array($highlights)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn ($item) => is_string($item) ? trim($item) : '',
            $highlights
        )));
    }

    private function normalizeSentiment(string $sentiment): string
    {
        $sentiment = Str::lower(trim($sentiment));

        return in_array($sentiment, ['positive', 'mixed', 'negative', 'neutral'], true)
            ? $sentiment
            : 'neutral';
    }

    /**
     * @param  list<string>  $highlights
     * @return array{
     *     summary: string,
     *     sentiment: string,
     *     highlights: list<string>,
     *     source: string,
     *     review_count: int,
     *     generated_at: string
     * }
     */
    private function payload(
        string $summary,
        string $sentiment,
        array $highlights,
        string $source,
        int $reviewCount,
    ): array {
        return [
            'summary' => $summary,
            'sentiment' => $sentiment,
            'highlights' => $highlights,
            'source' => $source,
            'review_count' => $reviewCount,
            'generated_at' => Carbon::now()->toIso8601String(),
        ];
    }
}
