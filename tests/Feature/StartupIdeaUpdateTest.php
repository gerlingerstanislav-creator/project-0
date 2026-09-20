<?php

namespace Tests\Feature;

use App\Models\StartupIdea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StartupIdeaUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_startup_idea(): void
    {
        $user = User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('secret'),
        ]);

        $idea = StartupIdea::create([
            'slug' => 'admin-test',
            'title' => 'Старое название',
            'description' => 'Старое описание',
        ]);

        $response = $this->actingAs($user)->patchJson(route('tools.tool1.update', $idea), [
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('startup_ideas', [
            'id' => $idea->id,
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);
    }

    public function test_editor_can_update_startup_idea(): void
    {
        $user = User::create([
            'username' => 'editor',
            'role' => 'editor',
            'password' => Hash::make('secret'),
        ]);

        $idea = StartupIdea::create([
            'slug' => 'editor-test',
            'title' => 'Старое название',
            'description' => 'Старое описание',
        ]);

        $this->actingAs($user)
            ->patch(route('tools.tool1.update', $idea), [
                'title' => 'Новое название',
                'description' => 'Новое описание',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('startup_ideas', [
            'id' => $idea->id,
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);
    }
}
