<?php

namespace Tests\Feature;

use App\Models\StartupIdea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StartupIdeaUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_startup_idea_can_be_updated(): void
    {
        $idea = StartupIdea::create([
            'slug' => 'test-idea',
            'title' => 'Старое название',
            'description' => 'Старое описание',
        ]);

        $response = $this->patchJson(route('tools.tool1.update', $idea), [
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonPath('idea.title', 'Новое название')
            ->assertJsonPath('idea.description', 'Новое описание');

        $this->assertDatabaseHas('startup_ideas', [
            'id' => $idea->id,
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);
    }
}
