<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    public function test_weather_page_contains_camera_configuration_for_each_resort(): void
    {
        Http::fake([
            'https://api.open-meteo.com/*' => Http::response([
                'current' => ['temperature_2m' => -4.2],
            ]),
        ]);

        $response = $this->get('/ski-resort');

        $response->assertOk()
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
