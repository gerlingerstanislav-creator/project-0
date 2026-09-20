@php($cityJson = base64_encode(json_encode($cities, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)))
<x-layout>
    <section class="page weather-page" data-weather-app data-cities="{{ $cityJson }}">
        <div class="weather-page__intro">
            <div>
                <h1>Погода</h1>
                <p class="page__description">Погода на сегодня и завтра для Ульяновска, Москвы и Мюнхена.</p>
            </div>
            <div class="weather-page__status">Обновление автоматически<br>каждые 10 минут</div>
        </div>
        <div class="weather-page__cards">
            @foreach ($cities as $city)
                <div data-weather-city="{{ $city['id'] }}" aria-live="polite">
                    <article class="weather-card">
                        <a class="weather-card__photo-link" href="{{ $city['camera'] }}" target="_blank" rel="noopener" aria-label="Открыть веб-камеру: {{ $city['name'] }}"><img class="weather-card__photo" src="{{ $city['photo'] }}" alt="{{ $city['name'] }}" loading="lazy"><span class="weather-card__camera-label">Камера</span></a>
                        <div class="weather-card__body">
                            <div class="weather-card__header">
                                <div><h2>{{ $city['name'] }}</h2><p>{{ $city['region'] }}</p></div>
                                <div class="weather-card__current-temp">—</div>
                            </div>
                            <div class="weather-card__condition">Загружаем актуальные данные…</div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <p class="page__eyebrow">06 / WEATHER</p>
    </section>
</x-layout>
