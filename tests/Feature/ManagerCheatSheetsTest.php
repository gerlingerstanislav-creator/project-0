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
            ->assertSee('Менеджерские шпаргалки')
            ->assertSee('Тестовая шпаргалка')
            ->assertSee('Проверить факт.');
    }
}