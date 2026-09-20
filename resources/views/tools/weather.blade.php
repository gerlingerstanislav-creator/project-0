@php($cityJson = base64_encode(json_encode($cities, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)))
<x-layout>
    <section class="page weather-page" data-weather-app data-cities="{{ $cityJson }}">
        <div class="weather-page__intro">
            <div>
                <h1>Погода</h1>
                <p class="page__description">Погода на сегодня и завтра для Ульяновска, Москвы и Мюнхена.</p>
            </div>
            <div class="weather-page__status">Обновление автоматически<br>каждую минуту</div>
        </div>

        <div class="weather-page__cards">
            @foreach ($cities as $city)
                <article class="weather-card">
                    @if ($city['cameraLive'] && ($city['cameraType'] ?? null) === 'hls')
                        <div class="weather-card__photo-link weather-card__photo-link--live">
                            <video class="weather-card__camera-video" data-hls-src="{{ $city['cameraStream'] }}" autoplay muted playsinline controls preload="metadata" poster="{{ $city['photo'] }}"></video>
                            <a class="weather-card__camera-label" href="{{ $city['camera'] }}" target="_blank" rel="noopener">Источник камеры ↗</a>
                        </div>
                    @elseif ($city['cameraLive'])
                        <div class="weather-card__photo-link weather-card__photo-link--live">
                            <iframe class="weather-card__camera-frame" src="{{ $city['cameraEmbed'] ?? $city['camera'] }}" title="Актуальная веб-камера: {{ $city['name'] }}" loading="eager" allow="autoplay; fullscreen; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            <a class="weather-card__camera-label" href="{{ $city['camera'] }}" target="_blank" rel="noopener">Открыть источник камеры ↗</a>
                        </div>
                    @else
                        <div class="weather-card__camera-offline">
                            <span>CAMERA OFFLINE</span>
                            <a class="weather-card__camera-label" href="{{ $city['camera'] }}" target="_blank" rel="noopener">Проверить источник камеры ↗</a>
                        </div>
                    @endif

                    <div class="weather-card__body">
                        <div class="weather-card__header">
                            <div>
                                <div class="weather-card__city-line">
                                    <h2>{{ $city['name'] }}</h2>
                                    <span class="weather-card__current-temp">{{ $city['currentTemperature'] !== null ? round($city['currentTemperature']) . '°C' : '—' }}</span>
                                </div>
                                <p>{{ $city['region'] }}</p>
                            </div>
                        </div>

                        <div class="weather-card__forecast" data-weather-forecast="{{ $city['id'] }}">
                            <div class="weather-row weather-row--loading">Загружаем актуальный прогноз…</div>
                        </div>

                        <div class="weather-card__updated">Данные обновляются автоматически каждую минуту · источник: Open-Meteo</div>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="page__eyebrow">06 / WEATHER</p>
    </section>
</x-layout>
