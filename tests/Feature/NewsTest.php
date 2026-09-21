<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\NewsTranslationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        Http::fake([
            '*' => Http::response(
                '<?xml version="1.0"?><rss><channel><item><title>OpenAI launches new AI model</title><link>https://example.com/article</link><description>AI software developer news.</description><pubDate>Mon, 21 Sep 2026 05:00:00 GMT</pubDate></item></channel></rss>',
                200,
                ['Content-Type' => 'application/rss+xml']
            ),
        ]);
    }

    public function test_news_page_requires_authentication(): void
    {
        $this->get('/news')->assertRedirect('/login');
    }

    public function test_news_translation_uses_libretranslate_when_configured(): void
    {
        Config::set('services.translation.url', 'http://127.0.0.1:5000');

        Http::fake([
            'http://127.0.0.1:5000/translate' => Http::response([
                'translatedText' => [
                    'Запускается новая модель ИИ',
                    'Новости разработчика программного обеспечения с ИИ.',
                ],
            ], 200),
        ]);

        $service = app(NewsTranslationService::class);
        $translations = $service->translate([
            'OpenAI launches new AI model',
            'AI software developer news.',
        ]);

        $this->assertSame('Запускается новая модель ИИ', $translations[0]);
        $this->assertSame('Новости разработчика программного обеспечения с ИИ.', $translations[1]);

        Http::assertSent(fn ($request) =>
            $request->url() === 'http://127.0.0.1:5000/translate'
            && $request['q'] === [
                'OpenAI launches new AI model',
                'AI software developer news.',
            ]
        );
    }

    public function test_news_feedback_changes_relevance_and_is_returned_to_page(): void
    {
        $user = $this->makeUser('news-feedback-test');

        $this->actingAs($user)->post('/news/feedback', [
            'scope' => 'article',
            'target_key' => sha1('https://example.com/article'),
            'action' => 'more',
            'categories' => ['AI', 'IT'],
            'sources' => ['TechCrunch'],
        ])->assertRedirect();

        $this->assertDatabaseHas('news_feedback', [
            'user_id' => $user->id,
            'scope' => 'article',
            'target_key' => sha1('https://example.com/article'),
            'action' => 'more',
        ]);

        $this->actingAs($user)->get('/news')
            ->assertInertia(fn ($page) => $page
                ->where('feedback.0.action', 'more')
                ->where('articles.articles.0.relevance', fn ($value) => $value >= 0.55)
            );
    }

    public function test_news_page_renders_aggregated_articles(): void
    {
        $this->actingAs($this->makeUser('news-test'))->get('/news')->assertOk();
    }

    private function makeUser(string $username): User
    {
        return User::query()->create([
            'username' => $username,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
