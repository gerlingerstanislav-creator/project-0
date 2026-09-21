<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class NewsAggregatorService
{
    public function __construct(private readonly NewsTranslationService $translationService) {}

    private const SOURCES = [
        ['name' => 'TechCrunch', 'url' => 'https://techcrunch.com/feed/', 'quality' => 0.92, 'categories' => ['IT', 'AI', 'Стартапы', 'Бизнес']],
        ['name' => 'Ars Technica', 'url' => 'https://feeds.arstechnica.com/arstechnica/index', 'quality' => 0.94, 'categories' => ['IT', 'Наука', 'Бизнес']],
        ['name' => 'Habr', 'url' => 'https://habr.com/ru/rss/all/?fl=ru', 'quality' => 0.82, 'categories' => ['IT', 'Программирование', 'AI']],
        ['name' => 'Hacker News', 'url' => 'https://hnrss.org/frontpage', 'quality' => 0.78, 'categories' => ['IT', 'Программирование', 'Стартапы']],
        ['name' => 'The Guardian — Technology', 'url' => 'https://www.theguardian.com/technology/rss', 'quality' => 0.9, 'categories' => ['IT', 'AI', 'Бизнес']],
        ['name' => 'The Guardian — Politics', 'url' => 'https://www.theguardian.com/politics/rss', 'quality' => 0.9, 'categories' => ['Политика', 'Мир']],
        ['name' => 'The Guardian — World', 'url' => 'https://www.theguardian.com/world/rss', 'quality' => 0.9, 'categories' => ['Мир', 'Политика']],
        ['name' => 'The Guardian — Business', 'url' => 'https://www.theguardian.com/business/rss', 'quality' => 0.9, 'categories' => ['Бизнес', 'Мир']],
        ['name' => 'BBC News', 'url' => 'https://feeds.bbci.co.uk/news/rss.xml', 'quality' => 0.95, 'categories' => ['Мир', 'Политика', 'Бизнес', 'Наука']],
    ];

    private const PROFILE = [
        'IT' => 1.0,
        'AI' => 1.0,
        'Стартапы' => 1.0,
        'Программирование' => 0.95,
        'Бизнес' => 0.85,
        'Управление' => 0.8,
        'Наука' => 0.7,
        'Мир' => 0.65,
        'Политика' => 0.55,
        'Спорт' => 0.5,
    ];

    public function getFeed(): array
    {
        return Cache::remember('news-aggregator:feed', now()->addMinutes(5), function (): array {
            $responses = Http::pool(function ($pool) {
                return collect(self::SOURCES)->mapWithKeys(function (array $source) use ($pool) {
                    return [$source['name'] => $pool
                        ->as($source['name'])
                        ->timeout(4)
                        ->connectTimeout(2)
                        ->withHeaders(['User-Agent' => 'project-0 news aggregator/1.0'])
                        ->get($source['url'])];
                })->all();
            }, concurrency: 6);

            $articles = [];

            foreach (self::SOURCES as $source) {
                $response = $responses[$source['name']] ?? null;

                if (! $response || $response instanceof Throwable || ! $response->successful()) {
                    continue;
                }

                foreach ($this->parseFeed($response->body()) as $article) {
                    $article['source'] = $source['name'];
                    $article['source_quality'] = $source['quality'];
                    $article['source_categories'] = $source['categories'];
                    $articles[] = $article;
                }
            }

            $articles = $this->deduplicate($articles);

            return [
                'articles' => array_values(array_slice($articles, 0, 80)),
                'sources' => collect(self::SOURCES)->map(fn (array $source) => $source['name'])->values()->all(),
                'updated_at' => now()->toIso8601String(),
            ];
        });
    }

    private function parseFeed(string $xml): array
    {
        libxml_use_internal_errors(true);
        $feed = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (! $feed) {
            return [];
        }

        $items = isset($feed->channel->item) ? $feed->channel->item : ($feed->entry ?? []);
        $articles = [];

        foreach ($items as $item) {
            $title = trim((string) ($item->title ?? ''));
            $url = trim((string) ($item->link ?? ''));

            if (! $url && isset($item->link['href'])) {
                $url = trim((string) $item->link['href']);
            }

            if (! $title || ! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

            $description = trim(strip_tags((string) ($item->description ?? $item->summary ?? '')));
            $published = (string) ($item->pubDate ?? $item->published ?? $item->updated ?? '');

            try {
                $publishedAt = $published ? Carbon::parse($published) : now();
            } catch (Throwable) {
                $publishedAt = now();
            }

            $articles[] = [
                'title' => $title,
                'url' => $url,
                'description' => mb_substr($description, 0, 360),
                'published_at' => $publishedAt->toIso8601String(),
            ];
        }

        return $articles;
    }

    private function deduplicate(array $articles): array
    {
        $groups = [];

        foreach ($articles as $article) {
            $key = $this->normalizeTitle($article['title']);
            $match = null;

            foreach (array_keys($groups) as $existing) {
                if ($this->titleSimilarity($key, $existing) >= 0.72) {
                    $match = $existing;
                    break;
                }
            }

            if ($match) {
                $groups[$match]['sources'][] = $article['source'];
                $groups[$match]['source_count']++;
                if ($article['source_quality'] > $groups[$match]['source_quality']) {
                    $groups[$match]['source_quality'] = $article['source_quality'];
                    $groups[$match]['url'] = $article['url'];
                }
                continue;
            }

            $article['sources'] = [$article['source']];
            $article['source_count'] = 1;
            $groups[$key] = $article;
        }

        $result = array_values($groups);

        foreach ($result as &$article) {
            $article['categories'] = $this->categoriesFor($article);
            $article['importance'] = $this->importanceFor($article);
            $article['relevance'] = $this->relevanceFor($article);
            $article['freshness'] = $this->freshnessFor($article['published_at']);
            $article['score'] = round(
                $article['importance']
                * (0.65 + $article['relevance'] * 0.35)
                * $article['freshness']
                * $article['source_quality']
                * (1 + min($article['source_count'] - 1, 3) * 0.08),
                3
            );
            $article['why'] = $this->why($article);
        }
        unset($article);

        usort($result, fn (array $a, array $b) => $b['score'] <=> $a['score']);

        $translationTexts = [];
        foreach (array_slice($result, 0, 40) as $article) {
            $translationTexts[] = $article['title'];
            if ($article['description'] !== '') {
                $translationTexts[] = $article['description'];
            }
        }

        $translations = $this->translationService->translate($translationTexts);
        $translationIndex = 0;

        foreach (array_slice($result, 0, 40, true) as $index => $article) {
            $result[$index]['title_ru'] = $translations[$translationIndex] ?? $article['title'];
            $translationIndex++;

            if ($article['description'] !== '') {
                $result[$index]['description_ru'] = $translations[$translationIndex] ?? $article['description'];
                $translationIndex++;
            } else {
                $result[$index]['description_ru'] = '';
            }
        }

        return $result;
    }

    private function categoriesFor(array $article): array
    {
        $text = mb_strtolower($article['title'] . ' ' . $article['description']);
        $map = [
            'AI' => ['ai', 'artificial intelligence', 'нейросет', 'ии ', 'модель', 'llm', 'agent'],
            'Программирование' => ['programming', 'developer', 'developer', 'код', 'software', 'github', 'open source', 'разработ'],
            'Стартапы' => ['startup', 'funding', 'venture', 'founder', 'стартап', 'инвестици'],
            'Бизнес' => ['business', 'market', 'company', 'revenue', 'эконом', 'рынок', 'acquisition'],
            'Управление' => ['management', 'manager', 'leadership', 'team', 'управлен', 'команд'],
            'Наука' => ['science', 'research', 'study', 'исследован', 'наук'],
            'Политика' => ['politic', 'election', 'government', 'parliament', 'president', 'закон', 'выбор', 'правительств'],
            'Мир' => ['world', 'ukraine', 'russia', 'europe', 'china', 'usa', 'international', 'международ'],
            'Спорт' => ['sport', 'football', 'basketball', 'tennis', 'ski', 'спорт'],
            'IT' => ['technology', 'tech', 'internet', 'cloud', 'chip', 'cyber', 'software', 'технолог', 'айти'],
        ];

        $categories = array_intersect_key(
            $map,
            array_filter($map, fn (array $keywords) => collect($keywords)->contains(fn (string $keyword) => str_contains($text, $keyword)))
        );

        return array_values(array_unique(array_merge($article['source_categories'], array_keys($categories))));
    }

    private function importanceFor(array $article): float
    {
        $text = mb_strtolower($article['title'] . ' ' . $article['description']);
        $high = ['acquisition', 'merger', 'launches', 'released', 'banned', 'law', 'regulation', 'election', 'war', 'breach', 'funding', 'банкрот', 'закон', 'регулирован', 'запрет', 'запуст', 'купил'];
        $medium = ['update', 'feature', 'partnership', 'study', 'research', 'funding', 'обновлен', 'партнерств', 'исследован'];

        $score = 0.45;
        foreach ($high as $keyword) {
            if (str_contains($text, $keyword)) {
                $score += 0.12;
            }
        }
        foreach ($medium as $keyword) {
            if (str_contains($text, $keyword)) {
                $score += 0.05;
            }
        }

        return min(1.0, round($score, 2));
    }

    private function relevanceFor(array $article): float
    {
        $text = mb_strtolower($article['title'] . ' ' . $article['description']);
        $score = 0.2;

        foreach (self::PROFILE as $category => $weight) {
            if (in_array($category, $article['categories'], true)) {
                $score += $weight * 0.16;
            }
        }

        $keywords = ['startup', 'founder', 'product', 'developer', 'software', 'ai', 'llm', 'open source', 'api', 'saas'];
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                $score += 0.06;
            }
        }

        return min(1.0, round($score, 2));
    }

    private function freshnessFor(string $publishedAt): float
    {
        $hours = max(0, now()->diffInHours(Carbon::parse($publishedAt)));
        return max(0.55, round(1 / (1 + ($hours / 30)), 3));
    }

    private function why(array $article): array
    {
        $reasons = [];

        if ($article['relevance'] >= 0.75) {
            $reasons[] = 'Высокая личная релевантность';
        } elseif ($article['relevance'] >= 0.55) {
            $reasons[] = 'Релевантно твоим интересам';
        }

        if ($article['importance'] >= 0.7) {
            $reasons[] = 'Высокая значимость';
        }

        if ($article['source_count'] > 1) {
            $reasons[] = $article['source_count'] . ' источника';
        }

        return $reasons ?: ['Попало в общий поток'];
    }

    private function normalizeTitle(string $title): string
    {
        $title = mb_strtolower(strip_tags($title));
        $title = preg_replace('/[^\\p{L}\\p{N} ]+/u', ' ', $title);
        return trim(preg_replace('/\\s+/u', ' ', $title));
    }

    private function titleSimilarity(string $a, string $b): float
    {
        $left = array_unique(array_filter(explode(' ', $a)));
        $right = array_unique(array_filter(explode(' ', $b)));

        if (! $left || ! $right) {
            return 0;
        }

        $intersection = count(array_intersect($left, $right));
        $union = count(array_unique(array_merge($left, $right)));

        return $union ? $intersection / $union : 0;
    }
}
