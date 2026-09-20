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
                'seasonDescription' => 'Сезон катания: ноябрь — апрель.',
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
                'seasonDescription' => 'Зимняя эксплуатация обычно проходит с декабря по май.',
            ],
            [
                'id' => 'rosa-khutor',
                'name' => 'Роза Хутор',
                'region' => 'Сочи, Краснодарский край, Россия',
                'latitude' => 43.66,
                'longitude' => 40.32,
                'camera' => 'https://rosakhutor.com/',
                'cameraEmbed' => 'https://rosakhutor.com/',
                'cameraLive' => true,
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Зимний горнолыжный сезон обычно приходится на декабрь — май.',
            ],
            [
                'id' => 'gazprom',
                'name' => 'Газпром',
                'region' => 'Лаура + Альпика, Сочи, Россия',
                'latitude' => 43.69,
                'longitude' => 40.27,
                'camera' => 'https://gazprom-resort.ru/',
                'cameraEmbed' => 'https://gazprom-resort.ru/',
                'cameraLive' => true,
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Горнолыжные зоны курорта — Лаура и Альпика; зимняя эксплуатация с декабря по май.',
            ],
            [
                'id' => 'bigwood',
                'name' => 'Большой Вудъявр',
                'region' => 'Кировск, Мурманская область, Россия',
                'latitude' => 67.6151,
                'longitude' => 33.6723,
                'camera' => 'https://bigwood.ru/cameras/',
                'cameraEmbed' => 'https://bigwood.ru/cameras/',
                'cameraLive' => true,
                'seasonStart' => 'ноябрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Продолжительный горнолыжный сезон — с ноября по конец мая.',
            ],
        ];

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
                // Weather is optional.
            }

            $year = now()->year;
            $schedule = match ($resort['id']) {
                'sheregesh', 'bigwood' => ['open' => "$year-11-01", 'close' => ($year + 1) . '-05-31'],
                default => ['open' => "$year-12-01", 'close' => ($year + 1) . '-05-31'],
            };

            $openDate = now()->createFromFormat('Y-m-d', $schedule['open'])->startOfDay();
            $closeDate = now()->createFromFormat('Y-m-d', $schedule['close'])->endOfDay();

            if (now()->between($openDate, $closeDate)) {
                $resort['status'] = 'open';
                $resort['statusLabel'] = 'Сезон открыт';
            } elseif (now()->lt($openDate)) {
                $resort['status'] = 'closed';
                $resort['statusLabel'] = 'До открытия сезона';
            } else {
                $resort['status'] = 'closed';
                $resort['statusLabel'] = 'Сезон завершён';
            }
        }
        unset($resort);

        return view('tools.weather', [
            'title' => 'Горнолыжные курорты',
            'resorts' => $resorts,
        ]);
    }
}
