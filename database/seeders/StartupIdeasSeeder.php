<?php

namespace Database\Seeders;

use App\Models\StartupIdea;
use Illuminate\Database\Seeder;

class StartupIdeasSeeder extends Seeder
{
    public function run(): void
    {
        $ideas = [
            [
                'slug' => 'creator-workflow-micro-tools',
                'title' => 'Набор микротулов для создателей контента',
                'description' => 'Небольшой сервис для решения узких задач авторов: подготовка материалов из длинного контента, организация публикаций, аналитика и другие повторяющиеся операции. Идея основана на актуальном направлении creator economy и специализированных AI-инструментов.',
            ],
            [
                'slug' => 'ai-financial-ops-for-small-business',
                'title' => 'AI-финансовый помощник для малого бизнеса',
                'description' => 'Сервис, который собирает счета, платежи и финансовые документы в одном месте, помогает владельцу видеть денежный поток и подсказывает, какие операции требуют внимания. Фокус — не на универсальном AI, а на конкретном финансовом workflow малого бизнеса.',
            ],
            [
                'slug' => 'small-business-sustainability-audit',
                'title' => 'Автоматизированный аудит устойчивости для малого бизнеса',
                'description' => 'Инструмент, который помогает небольшой компании собрать данные об энергии, отходах, упаковке и поставщиках, а затем формирует понятный план улучшений и отчёт. Идея опирается на растущий спрос на sustainability-инструменты и автоматизацию экологических аудитов.',
            ],
        ];

        foreach ($ideas as $idea) {
            StartupIdea::updateOrCreate(
                ['slug' => $idea['slug']],
                $idea,
            );
        }
    }
}
