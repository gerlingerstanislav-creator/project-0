const weatherApp = document.querySelector('[data-weather-app]');

if (!weatherApp) {
    // This entry is loaded globally but only activates on the ski-resort page.
} else {
    const resorts = JSON.parse(atob(weatherApp.dataset.cities));
    const refreshInterval = 60 * 1000;

    const weatherDescriptions = {
        0: 'Ясно', 1: 'Преимущественно ясно', 2: 'Переменная облачность', 3: 'Пасмурно',
        45: 'Туман', 48: 'Изморозь и туман', 51: 'Морось', 53: 'Морось', 55: 'Сильная морось',
        56: 'Ледяная морось', 57: 'Сильная ледяная морось', 61: 'Небольшой дождь', 63: 'Дождь',
        65: 'Сильный дождь', 66: 'Ледяной дождь', 67: 'Сильный ледяной дождь', 71: 'Небольшой снег',
        73: 'Снег', 75: 'Сильный снег', 77: 'Снежные зёрна', 80: 'Ливни', 81: 'Ливни',
        82: 'Сильные ливни', 85: 'Снегопад', 86: 'Сильный снегопад', 95: 'Гроза',
        96: 'Гроза с градом', 99: 'Сильная гроза с градом',
    };

    const formatDate = (date, index) => {
        const formatted = new Intl.DateTimeFormat('ru-RU', {
            weekday: 'short',
            day: 'numeric',
            month: 'short',
        }).format(new Date(date + 'T12:00:00'));

        return index === 0 ? 'Сегодня' : formatted.replace('.', '');
    };

    const iconFor = (code) => code >= 95 ? '⚡' : code >= 80 ? '🌧️' : code >= 71 ? '❄️' : code >= 51 ? '🌦️' : code >= 1 ? '⛅' : '☀️';

    const renderForecast = (data) => data.daily.time.map((date, index) => {
        const max = data.daily.temperature_2m_max[index];
        const min = data.daily.temperature_2m_min[index];
        const code = data.daily.weather_code[index];
        const rain = data.daily.precipitation_probability_max[index];

        return `<div class="weather-day">
            <span class="weather-day__date">${formatDate(date, index)}</span>
            <span class="weather-day__icon" aria-hidden="true">${iconFor(code)}</span>
            <span class="weather-day__temperature">${Number.isFinite(max) ? Math.round(max) : '—'}° <small>${Number.isFinite(min) ? Math.round(min) : '—'}°</small></span>
            <span class="weather-day__condition">${weatherDescriptions[code] ?? 'Погодные условия'}</span>
            <span class="weather-day__rain">${Number.isFinite(rain) ? rain + '%' : '—'}</span>
        </div>`;
    }).join('');

    const loadWeather = async () => {
        await Promise.all(resorts.map(async (resort) => {
            const url = new URL('https://api.open-meteo.com/v1/forecast');
            url.search = new URLSearchParams({
                latitude: resort.latitude,
                longitude: resort.longitude,
                daily: 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max',
                forecast_days: '7',
                timezone: 'auto',
            });

            const target = document.querySelector(`[data-weather-forecast="${resort.id}"]`);

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('weather_request_failed');
                }

                target.innerHTML = renderForecast(await response.json());
            } catch {
                target.innerHTML = '<p class="weather-card__error">Не удалось получить актуальный прогноз.</p>';
            }
        }));
    };

    loadWeather();
    window.setInterval(loadWeather, refreshInterval);

    document.querySelectorAll('[data-camera-carousel]').forEach((carousel) => {
        const resortId = carousel.closest('.ski-card')?.querySelector('[data-weather-forecast]')?.dataset.weatherForecast;
        const resort = resorts.find((item) => item.id === resortId);
        const cameras = resort?.cameras ?? [];
        const frame = carousel.querySelector('[data-camera-frame]');
        const image = carousel.querySelector('[data-camera-image]');
        const placeholder = carousel.querySelector('[data-camera-placeholder]');
        const loading = carousel.querySelector('[data-camera-loading]');
        const name = carousel.querySelector('[data-camera-name]');
        const message = carousel.querySelector('[data-camera-message]');
        const link = carousel.querySelector('[data-camera-link]');
        const source = carousel.querySelector('[data-camera-source]');
        const counter = carousel.querySelector('[data-camera-index]');

        if (!frame || !image || !placeholder || !loading || !name || !message || !link || !source || cameras.length === 0) return;

        let index = 0;

        const renderCamera = () => {
            const camera = cameras[index];
            const type = camera.type ?? (camera.playerUrl ? 'video' : camera.imageUrl ? 'image' : 'external');

            loading.hidden = true;
            frame.hidden = true;
            image.hidden = true;
            placeholder.hidden = true;
            frame.removeAttribute('src');
            image.removeAttribute('src');

            name.textContent = camera.name;
            link.href = camera.url;
            source.href = camera.url;
            source.textContent = type === 'external' ? 'Открыть все камеры ↗' : 'Источник камеры ↗';

            if (type === 'video' && camera.playerUrl) {
                frame.src = camera.playerUrl;
                frame.title = `Трансляция камеры ${camera.name}`;
                frame.hidden = false;
            } else if (type === 'image' && camera.imageUrl) {
                image.src = `${camera.imageUrl}${camera.imageUrl.includes('?') ? '&' : '?'}v=${Date.now()}`;
                image.alt = camera.name;
                image.hidden = false;
            } else {
                message.textContent = 'Камера доступна на официальной странице курорта. Откройте источник для просмотра актуальной трансляции.';
                placeholder.hidden = false;
            }

            if (counter) counter.textContent = String(index + 1);
        };

        renderCamera();

        if (cameras.length < 2) return;

        carousel.querySelector('[data-camera-prev]')?.addEventListener('click', () => {
            index = (index - 1 + cameras.length) % cameras.length;
            renderCamera();
        });

        carousel.querySelector('[data-camera-next]')?.addEventListener('click', () => {
            index = (index + 1) % cameras.length;
            renderCamera();
        });
    });
}
