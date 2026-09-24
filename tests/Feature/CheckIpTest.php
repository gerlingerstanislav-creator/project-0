<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckIpTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_check_ip(): void
    {
        $this->get('/check-ip')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_open_check_ip(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/check-ip')->assertOk();
    }

    public function test_lookup_validates_ip(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson('/check-ip/lookup', ['ip' => 'not-an-ip'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('ip');
    }

    public function test_private_ip_does_not_make_external_request(): void
    {
        Http::preventStrayRequests();
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/check-ip/lookup', ['ip' => '192.168.1.10'])
            ->assertOk()
            ->assertJsonPath('version', 'IPv4')
            ->assertJsonPath('scope', 'private / reserved')
            ->assertJsonPath('rdap', null);

        Http::assertNothingSent();
    }

    public function test_public_ip_includes_rdap_data(): void
    {
        Http::fake([
            'https://rdap.org/ip/8.8.8.8' => Http::response([
                'name' => 'GOGL',
                'handle' => 'NET-8-8-8-0-1',
                'startAddress' => '8.8.8.0',
                'endAddress' => '8.8.8.255',
                'country' => 'US',
                'status' => ['active'],
                'events' => [],
                'entities' => [],
            ]),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user)->postJson('/check-ip/lookup', ['ip' => '8.8.8.8'])
            ->assertOk()
            ->assertJsonPath('scope', 'public')
            ->assertJsonPath('rdap.name', 'GOGL')
            ->assertJsonPath('rdap.country', 'US');
    }
}
