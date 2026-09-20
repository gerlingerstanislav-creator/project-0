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

        $response = $this->get('/weather');

        $response->assertOk()
            ->assertSee('data-camera-carousel', false)
            ->assertSee('data-camera-count="6"', false)
            ->assertSee('data-camera-count="5"', false);

        preg_match('/data-cities="([^"]+)"/', $response->getContent(), $matches);

        $this->assertNotEmpty($matches[1]);

        $resorts = json_decode(base64_decode($matches[1]), true, 512, JSON_THROW_ON_ERROR);

        $bigwood = collect($resorts)->firstWhere('id', 'bigwood');
        $gazprom = collect($resorts)->firstWhere('id', 'gazprom');
        $krasnayaPolyana = collect($resorts)->firstWhere('id', 'krasnaya-polyana');

        $this->assertSame(
            'https://123streaming.ru/meetings/viewpep/eb29b1d745277d6ee9f0edfa70290d2c',
            $bigwood['cameras'][0]['playerUrl']
        );
        $this->assertSame(
            'https://polyanaski.ru/webcam/cam2.php?cam_id=265',
            $gazprom['cameras'][0]['playerUrl']
        );
        $this->assertSame('image', $krasnayaPolyana['cameras'][0]['type']);
        $this->assertStringContainsString(
            'polyana_960_panorama_spring',
            $krasnayaPolyana['cameras'][4]['imageUrl']
        );
    }
}
