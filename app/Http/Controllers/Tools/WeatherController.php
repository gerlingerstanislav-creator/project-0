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
                'cameras' => [
                    ['name' => 'Каскад. Олимпия-Экспресс нижняя станция', 'url' => 'https://www.dirsheregesh.ru/cameras/player/kaskad-olimpiia-ekspress-nizniaia-stanciia', 'playerUrl' => 'https://www.dirsheregesh.ru/cameras/player/kaskad-olimpiia-ekspress-nizniaia-stanciia'],
                    ['name' => 'Сектор A', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=A'],
                    ['name' => 'Сектор B', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=B'],
                    ['name' => 'Сектор E', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=E'],
                    ['name' => 'Сектор F', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=F'],
                ],
                'seasonStart' => 'ноябрь 2026',
                'seasonEnd' => 'апрель 2027',
                'seasonDescription' => 'Ориентировочный сезон катания: ноябрь — апрель.',
            ],
            [
                'id' => 'krasnaya-polyana',
                'name' => 'Красная Поляна',
                'region' => 'Сочи, Краснодарский край, Россия',
                'latitude' => 43.68,
                'longitude' => 40.20,
                'cameras' => [
                    ['name' => 'Веб-камеры курорта', 'url' => 'https://krasnayapolyanaresort.ru/webcams'],
                ],
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Ориентировочный зимний сезон: декабрь — май.',
            ],
            [
                'id' => 'rosa-khutor',
                'name' => 'Роза Хутор',
                'region' => 'Сочи, Краснодарский край, Россия',
                'latitude' => 43.66,
                'longitude' => 40.32,
                'cameras' => [
                    ['name' => 'Веб-камеры курорта', 'url' => 'https://live.rosakhutor.com/'],
                ],
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Ориентировочный зимний сезон: декабрь — май.',
            ],
            [
                'id' => 'gazprom',
                'name' => 'Газпром',
                'region' => 'Лаура + Альпика, Сочи, Россия',
                'latitude' => 43.69,
                'longitude' => 40.27,
                'cameras' => [
                    ['name' => 'Веб-камеры курорта', 'url' => 'https://gazprom.polyanaski.ru/'],
                ],
                'seasonStart' => 'декабрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Лаура и Альпика; ориентировочный зимний сезон: декабрь — май.',
            ],
            [
                'id' => 'bigwood',
                'name' => 'Большой Вудъявр',
                'region' => 'Кировск, Мурманская область, Россия',
                'latitude' => 67.6151,
                'longitude' => 33.6723,
                'cameras' => [
                    ['name' => 'Веб-камеры курорта', 'url' => 'https://bigwood.ru/cameras/'],
                ],
                'seasonStart' => 'ноябрь 2026',
                'seasonEnd' => 'май 2027',
                'seasonDescription' => 'Ориентировочный сезон катания: ноябрь — май.',
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
                $resort['statusLabel'] = 'Активен';
            } elseif (now()->lt($openDate)) {
                $resort['status'] = 'closed';
                $resort['statusLabel'] = 'Не активен';
            } else {
                $resort['status'] = 'closed';
                $resort['statusLabel'] = 'Не активен';
            }
        }
        unset($resort);

        return view('tools.weather', [
            'title' => 'Горнолыжные курорты',
            'resorts' => $resorts,
        ]);
    }
}
