<?php

namespace Tests\Feature;

use App\Models\StartupIdea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_tools_without_edit_controls(): void
    {
        $this->get(route('tools.tool1'))
            ->assertSuccessful()
            ->assertInertia(fn ($page) => $page
                ->component('Tool1')
                ->where('canEditIdeas', false)
            );

        $this->get(route('tools.tool2'))
            ->assertInertia(fn ($page) => $page->component('Tool2'));

        $this->get(route('tools.tool3'))
            ->assertInertia(fn ($page) => $page->component('Tool3'));

        $this->get(route('login'))
            ->assertInertia(fn ($page) => $page->component('Login'));
    }

    public function test_admin_can_login(): void
    {
        User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('secret'),
        ]);

        $this->post(route('login.store'), [
            'username' => 'admin',
            'password' => 'secret',
        ])->assertRedirect(route('tools.tool1'));

        $this->assertAuthenticatedAs(User::where('username', 'admin')->first());
    }

    public function test_editor_can_login(): void
    {
        User::create([
            'username' => 'editor',
            'role' => 'editor',
            'password' => Hash::make('secret'),
        ]);

        $this->post(route('login.store'), [
            'username' => 'editor',
            'password' => 'secret',
        ])->assertRedirect(route('tools.tool1'));

        $this->assertAuthenticatedAs(User::where('username', 'editor')->first());
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('secret'),
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'username' => 'admin',
                'password' => 'wrong',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('username');
    }

    public function test_only_admin_and_editor_see_edit_controls(): void
    {
        $idea = StartupIdea::create([
            'slug' => 'visibility-test',
            'title' => 'Название',
            'description' => 'Описание',
        ]);

        $admin = User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('secret'),
        ]);

        $viewer = User::create([
            'username' => 'viewer',
            'role' => 'viewer',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($admin)
            ->get(route('tools.tool1'))
            ->assertInertia(fn ($page) => $page
                ->component('Tool1')
                ->where('canEditIdeas', true)
            );

        $this->actingAs($viewer)
            ->get(route('tools.tool1'))
            ->assertInertia(fn ($page) => $page
                ->component('Tool1')
                ->where('canEditIdeas', false)
            );
    }

    public function test_viewer_cannot_update_startup_ideas(): void
    {
        $user = User::create([
            'username' => 'viewer',
            'role' => 'viewer',
            'password' => Hash::make('secret'),
        ]);

        $idea = StartupIdea::create([
            'slug' => 'viewer-test',
            'title' => 'Название',
            'description' => 'Описание',
        ]);

        $this->actingAs($user)
            ->patchJson(route('tools.tool1.update', $idea), [
                'title' => 'Новое название',
                'description' => 'Новое описание',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('startup_ideas', [
            'id' => $idea->id,
            'title' => 'Название',
            'description' => 'Описание',
        ]);
    }
}
