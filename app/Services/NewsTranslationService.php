<?php

namespace App\\Services;

use Minhyung\\LaravelTranslator\\Facades\\Translator;
use Throwable;

class NewsTranslationService
{
    public function translate(array $texts, string $sourceLang = 'auto'): array
    {
        $texts = array_values($texts);
        if ($texts === []) {
            return [];
        }

        $translations = [];

        foreach (array_chunk($texts, 10) as $chunk) {
            try {
                $batch = Translator::via('libretranslate')->translateBatch($chunk, 'ru', $sourceLang);

                foreach ($chunk as $index => $text) {
                    $translated = trim((string) ($batch[$index]->text ?? ''));
                    $translations[] = $translated !== '' ? $translated : $text;
                }
            } catch (Throwable $exception) {
                report($exception);

                foreach ($chunk as $text) {
                    $translations[] = $text;
                }
            }
        }

        return $translations;
    }
}
