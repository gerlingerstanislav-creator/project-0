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
        $this->assertCanUpdateIdeas('admin');
    }

    public function test_moderator_can_update_startup_idea(): void
    {
        $this->assertCanUpdateIdeas('moderator');
    }

    private function assertCanUpdateIdeas(string $role): void
    {
        $user = User::create([
            'username' => $role,
            'role' => $role,
            'password' => Hash::make('secret'),
        ]);

        $idea = StartupIdea::create([
            'slug' => $role . '-test',
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
