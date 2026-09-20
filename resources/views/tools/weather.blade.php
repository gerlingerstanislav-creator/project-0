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
                <div data-weather-city="{{ $city['id'] }}" aria-live="polite">
                    <article class="weather-card">
                        @if ($city['cameraLive'])
                            <a class="weather-card__photo-link weather-card__photo-link--live" href="{{ $city['camera'] }}" target="_blank" rel="noopener" aria-label="Открыть актуальную веб-камеру: {{ $city['name'] }}">
                                <iframe class="weather-card__camera-frame" src="{{ $city['camera'] }}" title="Актуальная веб-камера: {{ $city['name'] }}" loading="lazy"></iframe>
                                <span class="weather-card__camera-label">LIVE · камера</span>
                            </a>
                        @else
                            <a class="weather-card__photo-link" href="{{ $city['camera'] }}" target="_blank" rel="noopener" aria-label="Проверить веб-камеру: {{ $city['name'] }}">
                                <img class="weather-card__photo" src="{{ $city['photo'] }}" alt="{{ $city['name'] }}" loading="lazy">
                                <span class="weather-card__camera-label">Камера сейчас недоступна</span>
                            </a>
                        @endif
                        <div class="weather-card__body">
                            <div class="weather-card__header">
                                <div><h2>{{ $city['name'] }}</h2><p>{{ $city['region'] }}</p></div>
                                <div class="weather-card__current-temp">{{ $city['currentTemperature'] !== null ? round($city['currentTemperature']) . '°C' : '—' }}</div>
                            </div>
                            <div class="weather-card__condition">Актуальная температура</div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <p class="page__eyebrow">06 / WEATHER</p>
    </section>
</x-layout>
