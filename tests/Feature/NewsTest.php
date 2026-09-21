<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

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

    public function test_news_translation_is_added_when_deepl_is_configured(): void
    {
        putenv('DEEPL_AUTH_KEY=test-key');

        Http::fake([
            'https://api-free.deepl.com/*' => Http::response([
                'translations' => [
                    ['text' => 'Запускается новая модель ИИ'],
                    ['text' => 'Разработчик представил новую модель.'],
                ],
            ], 200),
            '*' => Http::response(
                '<?xml version="1.0"?><rss><channel><item><title>OpenAI launches new AI model</title><link>https://example.com/article</link><description>AI software developer news.</description><pubDate>Mon, 21 Sep 2026 02:00:00 GMT</pubDate></item></channel></rss>',
                200,
                ['Content-Type' => 'application/rss+xml']
            ),
        ]);

        $user = User::query()->create([
            'username' => 'news-translation-test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->actingAs($user)->get('/news')
            ->assertInertia(fn ($page) => $page
                ->where('articles.0.title_ru', 'Запускается новая модель ИИ')
                ->where('articles.0.description_ru', 'Разработчик представил новую модель.')
            );

        putenv('DEEPL_AUTH_KEY');
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
