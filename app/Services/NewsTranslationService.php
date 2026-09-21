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
            if ($text === '') {
                continue;
            }

            $cached = Cache::get($this->cacheKey($text));
            if ($cached !== null) {
                $result[$index] = $cached;
                continue;
            }

            $missing[$index] = $text;
        }

        $key = trim((string) env('DEEPL_AUTH_KEY', ''));
        if ($key === '' || ! $missing) {
            return $result;
        }

        foreach (array_chunk($missing, self::BATCH_SIZE, true) as $batch) {
            try {
                $response = Http::timeout(8)
                    ->connectTimeout(3)
                    ->withHeaders([
                        'Authorization' => 'DeepL-Auth-Key ' . $key,
                        'Content-Type' => 'application/json',
                    ])
                    ->post((string) env('DEEPL_API_URL', 'https://api-free.deepl.com/v2/translate'), [
                        'text' => array_values($batch),
                        'target_lang' => 'RU',
                    ]);

                if (! $response->successful()) {
                    continue;
                }

                $translations = $response->json('translations', []);
                $offset = 0;

                foreach ($batch as $index => $original) {
                    $translated = trim((string) ($translations[$offset]['text'] ?? ''));
                    $offset++;

                    if ($translated === '') {
                        continue;
                    }

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
