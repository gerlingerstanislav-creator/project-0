@php($resortJson = base64_encode(json_encode($resorts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)))
<x-layout>
    <section class="page ski-page" data-weather-app data-cities="{{ $resortJson }}">
        <div class="ski-page__intro">
            <div>
                <h1>Горнолыжные курорты</h1>
                <p class="page__description">Погода, камеры и состояние горнолыжного сезона на курортах Шерегеш и Красная Поляна.</p>
            </div>
            <div class="ski-page__status">Погода обновляется автоматически<br>каждую минуту</div>
        </div>

        <div class="ski-page__cards">
            @foreach ($resorts as $resort)
                <article class="ski-card">
                    <div class="ski-card__media">
                        @if ($resort['cameraLive'])
                            <iframe
                                class="ski-card__camera-frame"
                                src="{{ $resort['cameraEmbed'] }}"
                                title="Веб-камеры: {{ $resort['name'] }}"
                                loading="eager"
                                allow="autoplay; fullscreen; picture-in-picture"
                                referrerpolicy="strict-origin-when-cross-origin"
                            ></iframe>
                            <a class="ski-card__camera-label" href="{{ $resort['camera'] }}" target="_blank" rel="noopener">Все камеры ↗</a>
                        @else
                            <div class="ski-card__offline">
                                <strong>КАМЕРЫ OFFLINE</strong>
                                <a href="{{ $resort['camera'] }}" target="_blank" rel="noopener">Открыть источник ↗</a>
                            </div>
                        @endif
                    </div>

                    <div class="ski-card__body">
                        <div class="ski-card__heading">
                            <div>
                                <h2 class="ski-card__title">{{ $resort['name'] }}</h2>
                                <p class="ski-card__region">{{ $resort['region'] }}</p>
                            </div>
                            <span class="ski-card__status ski-card__status--{{ $resort['status'] }}">
                                {{ $resort['statusLabel'] }}
                            </span>
                        </div>

                        <div class="ski-card__meta">
                            <div class="ski-card__meta-item">
                                <div class="ski-card__meta-label">Открытие сезона</div>
                                <div class="ski-card__meta-value">{{ $resort['seasonStart'] }}</div>
                            </div>
                            <div class="ski-card__meta-item">
                                <div class="ski-card__meta-label">Закрытие сезона</div>
                                <div class="ski-card__meta-value">{{ $resort['seasonEnd'] }}</div>
                            </div>
                            <div class="ski-card__meta-item">
                                <div class="ski-card__meta-label">Сейчас</div>
                                <div class="ski-card__meta-value">{{ $resort['currentTemperature'] !== null ? round($resort['currentTemperature']) . '°C' : '—' }}</div>
                            </div>
                        </div>

                        <div class="ski-card__forecast" data-weather-forecast="{{ $resort['id'] }}">
                            <div class="weather-row weather-row--loading">Загружаем прогноз…</div>
                        </div>

                        <div class="ski-card__updated">{{ $resort['seasonDescription'] }} · источник погоды: Open-Meteo</div>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="page__eyebrow">06 / SKI RESORTS</p>
    </section>
</x-layout>
