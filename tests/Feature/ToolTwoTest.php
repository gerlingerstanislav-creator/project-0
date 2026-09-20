<?php

namespace Tests\Feature;

use Tests\TestCase;

class ToolTwoTest extends TestCase
{
    public function test_beer_game_page_is_public_and_renders_inertia_page(): void
    {
        $this->get('/tool-2')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Tool2')
                ->title('Степан, выпей')
            );
    }
}
