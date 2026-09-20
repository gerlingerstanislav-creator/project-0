@php($resortJson = base64_encode(json_encode($resorts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)))
<x-layout>
    <section class="page ski-page" data-weather-app data-cities="{{ $resortJson }}">
        <div class="ski-page__intro">
            <div>
                <h1>Горнолыжные курорты</h1>
                <p class="page__description">Погода, камеры и состояние горнолыжного сезона на горнолыжных курортах России.</p>
            </div>
            <div class="ski-page__status">Погода обновляется автоматически<br>каждую минуту</div>
        </div>

        <div class="ski-page__cards">
            @foreach ($resorts as $resort)
                <article class="ski-card">
                    <div class="ski-card__top">
                        <div class="ski-card__media" data-camera-carousel data-camera-count="{{ count($resort['cameras']) }}">
                            <div class="ski-card__camera-placeholder">
                                <div class="ski-card__camera-icon">◉</div>
                                <strong data-camera-name>{{ $resort['cameras'][0]['name'] }}</strong>
                                <span>Прямой поток этой камеры нельзя безопасно встроить на страницу без iframe целого сайта.</span>
                                <a data-camera-link href="{{ $resort['cameras'][0]['url'] }}" target="_blank" rel="noopener">Открыть камеру ↗</a>
                            </div>
                            @if (count($resort['cameras']) > 1)
                                <button class="ski-card__camera-arrow ski-card__camera-arrow--prev" type="button" data-camera-prev aria-label="Предыдущая камера">‹</button>
                                <button class="ski-card__camera-arrow ski-card__camera-arrow--next" type="button" data-camera-next aria-label="Следующая камера">›</button>
                                <div class="ski-card__camera-counter"><span data-camera-index>1</span> / {{ count($resort['cameras']) }}</div>
                            @endif
                            <a class="ski-card__camera-source" href="{{ $resort['cameras'][0]['url'] }}" target="_blank" rel="noopener">Источник камер ↗</a>
                        </div>

                        <div class="ski-card__body">
                            <div class="ski-card__heading">
                                <div>
                                    <h2 class="ski-card__title">{{ $resort['name'] }}</h2>
                                    <p class="ski-card__region">{{ $resort['region'] }}</p>
                                </div>
                                <span class="ski-card__status ski-card__status--{{ $resort['status'] }}">{{ $resort['statusLabel'] }}</span>
                            </div>

                            <div class="ski-card__meta">
                                <div class="ski-card__meta-item">
                                    <div class="ski-card__meta-label">Сезон</div>
                                    <div class="ski-card__meta-value">с {{ $resort['seasonStart'] }} по {{ $resort['seasonEnd'] }}</div>
                                </div>
                                <div class="ski-card__meta-item">
                                    <div class="ski-card__meta-label">Сейчас</div>
                                    <div class="ski-card__meta-value">{{ $resort['currentTemperature'] !== null ? round($resort['currentTemperature']) . '°C' : '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ski-card__forecast" data-weather-forecast="{{ $resort['id'] }}">
                        <div class="weather-row weather-row--loading">Загружаем прогноз…</div>
                    </div>

                    <div class="ski-card__updated">{{ $resort['seasonDescription'] }} · источник погоды: Open-Meteo</div>
                </article>
            @endforeach
        </div>

        <p class="page__eyebrow">06 / SKI RESORTS</p>
    </section>
</x-layout>
