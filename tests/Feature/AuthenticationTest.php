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

    public function test_guest_is_redirected_from_protected_pages(): void
    {
        foreach ([
            'tools.tool1',
            'tools.tool2',
            'tools.manager-cheat-sheets',
            'tools.ski-resort',
            'tests',
            'design-system',
        ] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }

    public function test_guest_can_view_login_and_homepage(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Home'));

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

    public function test_moderator_can_login(): void
    {
        User::create([
            'username' => 'moderator',
            'role' => 'moderator',
            'password' => Hash::make('secret'),
        ]);

        $this->post(route('login.store'), [
            'username' => 'moderator',
            'password' => 'secret',
        ])->assertRedirect(route('tools.tool1'));

        $this->assertAuthenticatedAs(User::where('username', 'moderator')->first());
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

    public function test_only_admin_and_moderator_see_edit_controls(): void
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

        $moderator = User::create([
            'username' => 'moderator',
            'role' => 'moderator',
            'password' => Hash::make('secret'),
        ]);

        $user = User::create([
            'username' => 'user',
            'role' => 'user',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($admin)
            ->get(route('tools.tool1'))
            ->assertInertia(fn ($page) => $page->where('canEditIdeas', true));

        $this->actingAs($moderator)
            ->get(route('tools.tool1'))
            ->assertInertia(fn ($page) => $page->where('canEditIdeas', true));

        $this->actingAs($user)
            ->get(route('tools.tool1'))
            ->assertInertia(fn ($page) => $page->where('canEditIdeas', false));
    }

    public function test_user_cannot_update_startup_ideas(): void
    {
        $user = User::create([
            'username' => 'user',
            'role' => 'user',
            'password' => Hash::make('secret'),
        ]);

        $idea = StartupIdea::create([
            'slug' => 'user-test',
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
