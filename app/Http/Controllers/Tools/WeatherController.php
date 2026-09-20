<?php

namespace App\Http\Controllers\Tools;

use Illuminate\View\View;

class WeatherController
{
    public function __invoke(): View
    {
        return view('tools.weather', [
            'title' => 'Погода',
            'cities' => [
                [
                    'id' => 'ulyanovsk',
                    'name' => 'Ульяновск',
                    'region' => 'Россия',
                    'latitude' => 54.3282,
                    'longitude' => 48.3866,
                    'photo' => 'https://cdn.tripster.ru/photos/42b7f940-ca5a-480b-8708-5c6e7984921d.jpg',
                'camera' => 'https://cam-world.ru/en/cams/ulyanovsk-sobornaya-ploschad-00000599',
                    'cameraLive' => false,
                ],
                [
                    'id' => 'moscow',
                    'name' => 'Москва',
                    'region' => 'Россия',
                    'latitude' => 55.7558,
                    'longitude' => 37.6173,
                    'photo' => 'https://hostel24.org/upload/ammina.optimizer/jpg-webp/q80/upload/medialibrary/644/8vgq0vjsp290qhozpy1l504ugqmmnmti.webp',
                'camera' => 'https://www.geocam.ru/online/taganskaya-square-webcam/',
                    'cameraLive' => true,
                ],
                [
                    'id' => 'munich',
                    'name' => 'Мюнхен',
                    'region' => 'Германия',
                    'latitude' => 48.1351,
                    'longitude' => 11.5820,
                    'photo' => 'https://www.worldplacesexplained.com/r2/og/places/munich-preview.webp',
                'camera' => 'https://www.munich.travel/en/webcam',
                    'cameraLive' => true,
                ],
            ],
        ]);
    }
}
