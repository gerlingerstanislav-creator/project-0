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
                    ['name' => 'Каскад. Олимпия-Экспресс — нижняя станция', 'url' => 'https://www.dirsheregesh.ru/cameras/player/kaskad-olimpiia-ekspress-nizniaia-stanciia', 'playerUrl' => 'https://www.dirsheregesh.ru/cameras/player/kaskad-olimpiia-ekspress-nizniaia-stanciia', 'type' => 'video'],
                    ['name' => 'Сектор A', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=A', 'type' => 'external'],
                    ['name' => 'Сектор B', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=B', 'type' => 'external'],
                    ['name' => 'Сектор E', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=E', 'type' => 'external'],
                    ['name' => 'Сектор F', 'url' => 'https://dirsheregesh.ru/cameras?sectors%5B%5D=F', 'type' => 'external'],
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
                    ['name' => 'Поляна 540 — главная площадь', 'url' => 'https://krasnayapolyanaresort.ru/webcams', 'imageUrl' => 'https://krasnayapolyanaresort.ru/assets/components/phpthumbof/cache/polyana_540_glavnaya_ploshad.1906a017ed2278d649eeb7c0f2a21404.jpg', 'type' => 'image'],
                    ['name' => 'Поляна 540 — променад', 'url' => 'https://krasnayapolyanaresort.ru/webcams', 'imageUrl' => 'https://krasnayapolyanaresort.ru/assets/components/phpthumbof/cache/polyana_540_promenad.1906a017ed2278d649eeb7c0f2a21404.jpg', 'type' => 'image'],
                    ['name' => 'Поляна 540 — ярмарка', 'url' => 'https://krasnayapolyanaresort.ru/webcams', 'imageUrl' => 'https://krasnayapolyanaresort.ru/assets/components/phpthumbof/cache/polyana_540_yarmarka.1906a017ed2278d649eeb7c0f2a21404.jpg', 'type' => 'image'],
                    ['name' => 'Парк Времена года — главная площадь', 'url' => 'https://krasnayapolyanaresort.ru/webcams', 'imageUrl' => 'https://krasnayapolyanaresort.ru/assets/components/phpthumbof/cache/polyana_540_park_vremena_goda_ploshad.1906a017ed2278d649eeb7c0f2a21404.jpg', 'type' => 'image'],
                    ['name' => 'Поляна 960 — панорама', 'url' => 'https://krasnayapolyanaresort.ru/webcams', 'imageUrl' => 'https://krasnayapolyanaresort.ru/assets/components/phpthumbof/cache/polyana_960_panorama_spring.1906a017ed2278d649eeb7c0f2a21404.jpg', 'type' => 'image'],
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
                    ['name' => 'Онлайн-камеры Роза Хутор', 'url' => 'https://live.rosakhutor.com/', 'type' => 'external'],
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
                    ['name' => 'Поляна 1389 — терраса', 'url' => 'https://polyanaski.ru/webcam/', 'playerUrl' => 'https://polyanaski.ru/webcam/cam2.php?cam_id=265', 'type' => 'video'],
                    ['name' => 'Приют Псехако — трасса C', 'url' => 'https://polyanaski.ru/webcam/', 'type' => 'external'],
                    ['name' => 'Альпика — трасса 12.1', 'url' => 'https://polyanaski.ru/webcam/', 'type' => 'external'],
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
                    ['name' => 'Нижняя станция К6', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/eb29b1d745277d6ee9f0edfa70290d2c', 'type' => 'video'],
                    ['name' => 'Сервисный центр, учебный склон', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/6dbcc745f4ea7c1b29fd17acd9802571', 'type' => 'video'],
                    ['name' => 'Верхняя станция подъемника К6', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/ea32b4bab318598f7def8cc026a5f9cb', 'type' => 'video'],
                    ['name' => 'К6-верх, трассы №15,17', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/f1b058a5f5ab587f0ac43ee9476b2e9c', 'type' => 'video'],
                    ['name' => 'Вершина, панорамный комплекс Плато', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/a3324713026557c47b0c958a5459a53f', 'type' => 'video'],
                    ['name' => 'Северный склон, парковка', 'url' => 'https://bigwood.ru/camera/', 'playerUrl' => 'https://123streaming.ru/meetings/viewpep/0aa7cfe61084aa8b137262349b7e69f4', 'type' => 'video'],
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
