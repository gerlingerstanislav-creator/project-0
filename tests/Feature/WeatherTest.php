<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    public function test_guest_is_redirected_from_weather_page(): void
    {
        $this->get('/ski-resort')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_weather_page(): void
    {
        Http::fake([
            'https://api.open-meteo.com/*' => Http::response([
                'current' => ['temperature_2m' => -4.2],
            ]),
        ]);

        $user = User::create([
            'username' => 'user',
            'role' => 'user',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($user)
            ->get('/ski-resort')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('SkiResort')
                ->has('resorts', 5)
                ->where('resorts.0.cameras.0.playerUrl', 'https://www.dirsheregesh.ru/cameras/player/kaskad-olimpiia-ekspress-nizniaia-stanciia')
                ->where('resorts.3.cameras.0.playerUrl', 'https://polyanaski.ru/webcam/cam2.php?cam_id=265')
                ->where('resorts.1.cameras.0.type', 'image')
                ->where('resorts.1.cameras.4.imageUrl', fn ($url) => str_contains($url, 'polyana_960_panorama_spring'))
            );
    }
}
