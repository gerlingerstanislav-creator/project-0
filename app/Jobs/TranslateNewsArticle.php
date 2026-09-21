<?php

namespace App\Jobs;

use App\Services\NewsTranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateNewsArticle implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public int $uniqueFor = 3600;

    public function __construct(public array $article) {}

    public function handle(NewsTranslationService $translationService): void
    {
        $texts = [$this->article['title']];
        if (($this->article['description'] ?? '') !== '') {
            $texts[] = $this->article['description'];
        }

        $translations = $translationService->translate($texts);

        Cache::put(
            'news-translation:' . $this->article['article_key'],
            [
                'title_ru' => $translations[0] ?? $this->article['title'],
                'description_ru' => $translations[1] ?? ($this->article['description'] ?? ''),
            ],
            now()->addDays(30),
        );
    }

    public function uniqueId(): string
    {
        return 'news-translation:' . $this->article['article_key'];
    }
}
