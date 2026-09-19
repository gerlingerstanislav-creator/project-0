<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_homepage_requires_authentication(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }
}
