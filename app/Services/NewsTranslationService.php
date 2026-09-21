<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class NewsTranslationService
{
    private const CACHE_TTL = 86400;
    private const BATCH_SIZE = 40;

    public function translate(array $texts): array
    {
        $texts = array_values($texts);
        $result = $texts;
        $missing = [];

        foreach ($texts as $index => $text) {
            if ($text === '') continue;
            $cached = Cache::get($this->cacheKey($text));
            if ($cached !== null) {
                $result[$index] = $cached;
                continue;
            }
            $missing[$index] = $text;
        }

        $url = rtrim((string) config('services.translation.url'), '/') . '/translate';
        if (! $missing || ! filter_var($url, FILTER_VALIDATE_URL)) return $result;

        foreach (array_chunk($missing, self::BATCH_SIZE, true) as $batch) {
            try {
                $response = Http::timeout(12)
                    ->connectTimeout(3)
                    ->acceptJson()
                    ->post($url, [
                        'q' => array_values($batch),
                        'source' => 'auto',
                        'target' => 'ru',
                        'format' => 'text',
                    ]);

                if (! $response->successful()) continue;

                $translations = $response->json();
                if (isset($translations['translatedText'])) {
                    $translations = [$translations];
                }

                $offset = 0;
                foreach ($batch as $index => $original) {
                    $translated = trim((string) ($translations[$offset]['translatedText'] ?? ''));
                    $offset++;
                    if ($translated === '') continue;

                    $result[$index] = $translated;
                    Cache::put($this->cacheKey($original), $translated, now()->addSeconds(self::CACHE_TTL));
                }
            } catch (Throwable) {
                continue;
            }
        }

        return $result;
    }

    private function cacheKey(string $text): string
    {
        return 'news-translation:' . sha1($text);
    }
}
