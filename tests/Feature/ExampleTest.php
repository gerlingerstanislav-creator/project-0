<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_public_transport_landing_is_accessible_without_login(): void
    {
        $this->get('/put-bez-pregrad')->assertOk()->assertSee('PutBezPregrad');
    }

    public function test_homepage_is_public(): void
    {
        $this->get('/')->assertOk();
    }
}
