<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ToolTwoTest extends TestCase
{
    public function test_beer_game_page_requires_authentication(): void
    {
        $this->get('/tool-2')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_beer_game(): void
    {
        $user = User::create([
            'username' => 'user',
            'role' => 'user',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($user)
            ->get('/tool-2')
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Tool2'));
    }
}
