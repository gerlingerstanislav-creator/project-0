<?php

namespace Tests\Feature;

use Tests\TestCase;

class ToolTwoTest extends TestCase
{
    public function test_beer_game_page_is_public_and_contains_game_controls(): void
    {
        $this->get('/tool-2')->assertOk()->assertSee('Степан, выпей')->assertSee('data-beer-bottle', false)->assertSee('data-beer-cup', false);
    }
}
