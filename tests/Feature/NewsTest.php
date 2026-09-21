<?php

namespace Tests\\Feature;

use App\\Models\\User;
use Illuminate\\Support\\Facades\\Cache;
use Illuminate\\Support\\Facades\\Hash;
use Illuminate\\Support\\Facades\\Http;
use Tests\\TestCase;

class NewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::forget('news-aggregator:feed');

        Http::fake([
            '*' => Http::response(
                '<?xml version="1.0"?><rss><channel><item><title>OpenAI launches new AI model</title><link>https://example.com/article</link><description>AI software developer news.</description><pubDate>Mon, 21 Sep 2026 02:00:00 GMT</pubDate></item></channel></rss>',
                200,
                ['Content-Type' => 'application/rss+xml']
            ),
        ]);
    }

    public function test_news_page_requires_authentication(): void
    {
        $this->get('/news')->assertRedirect('/login');
    }

    public function test_news_page_renders_aggregated_articles(): void
    {
        $user = User::query()->create([
            'username' => 'news-test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->actingAs($user)->get('/news')->assertOk();
    }
}
