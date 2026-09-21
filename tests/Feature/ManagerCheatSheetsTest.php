<?php

namespace Tests\Feature;

use App\Models\ManagerCheatSheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ManagerCheatSheetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_cheat_sheets_page_requires_authentication(): void
    {
        $this->get('/manager-cheat-sheets')->assertRedirect('/login');
    }

    public function test_weather_page_requires_authentication(): void
    {
        $this->get('/ski-resort')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_protected_pages(): void
    {
        $user = User::create([
            'username' => 'user',
            'role' => 'user',
            'password' => Hash::make('secret'),
        ]);

        ManagerCheatSheet::query()->create([
            'slug' => 'test',
            'title' => 'Тестовая шпаргалка',
            'content' => '<p>Проверить факт.</p>',
        ]);

        $this->actingAs($user)
            ->get('/manager-cheat-sheets')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('ManagerCheatSheets')
                ->has('cheatSheets', 1)
            );

        $this->actingAs($user)
            ->get('/ski-resort')
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
