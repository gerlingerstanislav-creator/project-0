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
            );

        $resorts = $response->viewData('page')['props']['resorts'] ?? [];

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
