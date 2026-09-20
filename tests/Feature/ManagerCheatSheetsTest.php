<?php

namespace Tests\Feature;

use App\Models\ManagerCheatSheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerCheatSheetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_cheat_sheets_page_is_public(): void
    {
        ManagerCheatSheet::query()->create([
            'slug' => 'test',
            'title' => 'Тестовая шпаргалка',
            'content' => '<p>Проверить факт.</p>',
        ]);

        $this->get('/manager-cheat-sheets')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('ManagerCheatSheets')
                ->has('cheatSheets', 1)
                ->where('cheatSheets.0.title', 'Тестовая шпаргалка')
                ->where('cheatSheets.0.content', '<p>Проверить факт.</p>')
            );
    }

    public function test_weather_page_is_public_and_contains_all_ski_resorts(): void
    {
        $this->get('/ski-resort')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('SkiResort')
                ->has('resorts', 5)
                ->where('resorts.0.name', 'Шерегеш')
                ->where('resorts.1.name', 'Красная Поляна')
                ->where('resorts.2.name', 'Роза Хутор')
                ->where('resorts.3.name', 'Газпром')
                ->where('resorts.4.name', 'Большой Вудъявр')
            );
    }
}
