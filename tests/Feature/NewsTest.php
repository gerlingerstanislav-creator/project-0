<?php

namespace Tests\Feature;

use App\Jobs\TranslateNewsArticle;
use App\Models\User;
use App\Services\NewsTranslationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Minhyung\LaravelTranslator\Facades\Translator;
use Tests\TestCase;

class NewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        Queue::fake();
        Translator::fake([
            'OpenAI launches new AI model' => 'Запускается новая модель ИИ',
            'AI software developer news.' => 'Новости разработчика программного обеспечения с ИИ.',
        ]);
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

    public function test_news_translation_uses_libretranslate_driver(): void
    {
        $translations = app(NewsTranslationService::class)->translate([
            'OpenAI launches new AI model',
            'AI software developer news.',
        ]);

        $this->assertSame('Запускается новая модель ИИ', $translations[0]);
        $this->assertSame('Новости разработчика программного обеспечения с ИИ.', $translations[1]);

        Translator::assertTranslated('OpenAI launches new AI model');
        Translator::assertTranslated('AI software developer news.');
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
            'target_key' => sha1('https://example.com/article'),
            'action' => 'more',
        ]);

        $this->actingAs($user)->get('/news')
            ->assertInertia(fn ($page) => $page
                ->where('feedback.0.action', 'more')
                ->where('articles.articles.0.relevance', fn ($value) => $value >= 0.55)
            );
    }

    public function test_news_preferences_are_persisted_between_requests(): void
    {
        $user = $this->makeUser('news-preferences-test');

        $this->actingAs($user)->put('/news/preferences', [
            'categories' => ['AI', 'Стартапы'],
            'min_importance' => 0.65,
        ])->assertRedirect();

        $this->assertDatabaseHas('news_preferences', [
            'user_id' => $user->id,
            'min_importance' => 0.65,
        ]);

        $this->actingAs($user)->get('/news')
            ->assertInertia(fn ($page) => $page
                ->where('selectedCategories', ['AI', 'Стартапы'])
                ->where('minImportance', 0.65)
            );
    }

    public function test_news_page_queues_translation_without_waiting_for_it(): void
    {
        $this->actingAs($this->makeUser('news-test'))
            ->get('/news')
            ->assertOk();

        $this->assertFalse(Cache::has('news-translation:' . sha1('https://example.com/article')));
        Queue::assertPushed(TranslateNewsArticle::class, fn (TranslateNewsArticle $job) => $job->article['title'] === 'OpenAI launches new AI model');
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
