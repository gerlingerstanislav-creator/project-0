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

    public function test_news_page_returns_original_article_content(): void
    {
        $this->actingAs($this->makeUser('news-content-test'))
            ->get('/news')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('articles.articles.0.title', 'OpenAI launches new AI model')
                ->where('articles.articles.0.description', 'AI software developer news.')
                ->missing('articles.articles.0.title_ru')
                ->missing('articles.articles.0.description_ru')
                ->missing('articles.articles.0.translation_pending')
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

    private function makeUser(string $username): User
    {
        return User::query()->create([
            'username' => $username,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
