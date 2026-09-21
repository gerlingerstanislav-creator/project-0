<?php

namespace App\Services;

use Minhyung\LaravelTranslator\Facades\Translator;
use Throwable;

class NewsTranslationService
{
    public function translate(array $texts): array
    {
        $texts = array_values($texts);
        if ($texts === []) {
            return [];
        }

        try {
            $translations = Translator::via('libretranslate')->translateBatch($texts, 'ru');

            return array_map(
                fn (string $text, int|string $index) => trim((string) ($translations[$index]->text ?? $text)),
                $texts,
                array_keys($texts),
            );
        } catch (Throwable) {
            return $texts;
        }
    }
}
