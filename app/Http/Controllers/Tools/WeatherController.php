<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class WeatherController
{
    public function __invoke(): View
    {
        $resorts = [
            [
                'id' => 'sheregesh',
                'name' => 'Шерегеш',
                'region' => 'Кемеровская область — Кузбасс, Россия',
                'latitude' => 52.9237,
                'longitude' => 87.9865,
                'camera' => 'https://dirsheregesh.ru/cameras',
                'cameraEmbed' => 'https://dirsheregesh.ru/cameras',
                'cameraLive' => true,
                'seasonStart' => 'ноябрь 2026',
                'seasonEnd' => 'апрель 2027',
                'seasonExact' => false,
                'seasonDescription' => 'Официально курорт указывает сезон катания с ноября по апрель.',
                'status' => 'season',
            ],
            [
                'id' => 'krasnaya-polyana',
                'name' => 'Красная Поляна',
                'region' => 'Сочи, Краснодарский край, Россия',
                'latitude' => 43.68,
                'longitude' => 40.20,
                'camera' => 'https://krasnayapolyanaresort.ru/webcams',
                'cameraEmbed' => 'https://krasnayapolyanaresort.ru/webcams',
                'cameraLive' => true,
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonExact' => false,
                'seasonDescription' => 'Для сезона 2026/27 точные даты открытия пока не опубликованы.',
                'status' => 'season',
            ],
        ];

        $today = now()->startOfDay();

        foreach ($resorts as &$resort) {
            $resort['currentTemperature'] = null;

            try {
                $response = Http::acceptJson()
                    ->timeout(5)
                    ->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $resort['latitude'],
                        'longitude' => $resort['longitude'],
                        'current' => 'temperature_2m,weather_code',
                        'timezone' => 'auto',
                    ]);

                if ($response->successful()) {
                    $resort['currentTemperature'] = $response->json('current.temperature_2m');
                }
            } catch (\Throwable) {
                // Weather is optional; the resort page remains usable if Open-Meteo is unavailable.
            }

            if ($resort['id'] === 'sheregesh') {
                $open = now()->year . '-11-01';
                $close = (now()->year + 1) . '-04-30';
            } else {
                $open = now()->year . '-12-01';
                $close = (now()->year + 1) . '-05-09';
            }

            $openDate = now()->createFromFormat('Y-m-d', $open)->startOfDay();
            $closeDate = now()->createFromFormat('Y-m-d', $close)->endOfDay();

            if ($today->between($openDate, $closeDate)) {
                $resort['status'] = 'open';
                $resort['statusLabel'] = 'Сезон открыт';
            } else {
                $resort['status'] = 'closed';
                $resort['statusLabel'] = $today->lt($openDate) ? 'До открытия сезона' : 'Сезон завершён';
            }
        }
        unset($resort);

        return view('tools.weather', [
            'title' => 'Горнолыжные курорты',
            'resorts' => $resorts,
        ]);
    }
}
