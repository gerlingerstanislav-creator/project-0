const toggle = document.querySelector('.menu-toggle');
const sidebar = document.querySelector('.sidebar');
const backdrop = document.querySelector('.sidebar-backdrop');

if (toggle && sidebar && backdrop) {
    const setMenuState = (open) => {
        sidebar.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.querySelector('.sr-only').textContent = open ? 'Закрыть меню' : 'Открыть меню';
    };

    toggle.addEventListener('click', () => {
        setMenuState(!sidebar.classList.contains('is-open'));
    });

    backdrop.addEventListener('click', () => setMenuState(false));

    document.querySelectorAll('.sidebar__link').forEach((link) => {
        link.addEventListener('click', () => setMenuState(false));
    });
}

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.querySelectorAll('[data-startup-idea]').forEach((idea) => {
    const editButton = idea.querySelector('[data-edit-button]');
    const title = idea.querySelector('[data-editable="title"]');
    const description = idea.querySelector('[data-editable="description"]');
    const actions = idea.querySelector('[data-edit-actions]');
    const cancelButton = idea.querySelector('[data-cancel-edit]');
    const saveButton = idea.querySelector('[data-save-edit]');
    const status = idea.querySelector('[data-edit-status]');
    const updateUrl = idea.dataset.updateUrl;

    if (!editButton || !title || !description || !actions || !cancelButton || !saveButton || !status || !csrfToken || !updateUrl) {
        return;
    }

    let original = {
        title: title.textContent.trim(),
        description: description.textContent.trim(),
    };

    const setEditing = (editing) => {
        idea.classList.toggle('is-editing', editing);
        title.contentEditable = String(editing);
        description.contentEditable = String(editing);
        actions.hidden = !editing;
        editButton.hidden = editing;

        if (editing) {
            idea.open = true;
            title.focus();
        }
    };

    title.addEventListener('click', (event) => {
        if (idea.classList.contains('is-editing')) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    editButton.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        original = {
            title: title.textContent.trim(),
            description: description.textContent.trim(),
        };
        status.textContent = '';
        setEditing(true);
    });

    cancelButton.addEventListener('click', () => {
        title.textContent = original.title;
        description.textContent = original.description;
        status.textContent = '';
        setEditing(false);
    });

    saveButton.addEventListener('click', async () => {
        const payload = {
            title: title.textContent.trim(),
            description: description.textContent.trim(),
        };

        if (!payload.title || !payload.description) {
            status.textContent = 'Заполни название и описание.';
            return;
        }

        saveButton.disabled = true;
        status.textContent = 'Сохраняем…';

        try {
            const response = await fetch(updateUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                throw new Error('save_failed');
            }

            const data = await response.json();

            title.textContent = data.idea.title;
            description.textContent = data.idea.description;
            original = {
                title: data.idea.title,
                description: data.idea.description,
            };
            status.textContent = 'Сохранено';
            setEditing(false);
        } catch {
            status.textContent = 'Не удалось сохранить изменения.';
        } finally {
            saveButton.disabled = false;
        }
    });
});

const beerGame = document.querySelector('[data-beer-game]');
if (beerGame) {
    const bottle = beerGame.querySelector('[data-beer-bottle]');
    const cup = beerGame.querySelector('[data-beer-cup]');
    const pour = beerGame.querySelector('[data-beer-pour]');
    const cupLiquid = beerGame.querySelector('[data-beer-cup-liquid]');
    const count = beerGame.querySelector('[data-beer-count]');
    let sips = 0;
    let busy = false;
    const render = () => {
        cupLiquid.style.setProperty('--beer-level', `${sips * 25}%`);
        count.textContent = `${sips} / 4 глотка`;
        cup.disabled = sips === 0 || busy;
        bottle.disabled = sips === 4 || busy;
    };
    bottle.addEventListener('click', () => {
        if (busy || sips >= 4) return;
        busy = true; bottle.classList.add('is-pouring'); pour.classList.add('is-active'); render();
        window.setTimeout(() => { sips += 1; bottle.classList.remove('is-pouring'); pour.classList.remove('is-active'); busy = false; render(); }, 700);
    });
    cup.addEventListener('click', () => {
        if (busy || sips === 0) return;
        busy = true; cup.classList.add('is-drinking');
        window.setTimeout(() => { sips = 0; cup.classList.remove('is-drinking'); busy = false; render(); }, 550);
    });
    render();
}


const weatherApp = document.querySelector('[data-weather-app]');
if (weatherApp) {
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
        const formatted = new Intl.DateTimeFormat('ru-RU', { weekday: 'short', day: 'numeric', month: 'short' })
            .format(new Date(date + 'T12:00:00'));
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
                if (!response.ok) throw new Error('weather_request_failed');
                target.innerHTML = renderForecast(await response.json());
            } catch {
                target.innerHTML = '<p class="weather-card__error">Не удалось получить актуальный прогноз.</p>';
            }
        }));
    };

    loadWeather();
    window.setInterval(loadWeather, refreshInterval);
}

document.querySelectorAll('[data-camera-carousel]').forEach((carousel) => {
    const resort = resorts?.find((item) => item.id === carousel.closest('.ski-card')?.querySelector('[data-weather-forecast]')?.dataset.weatherForecast);
    const cameras = resort?.cameras ?? [];
    if (cameras.length < 2) return;

    let index = 0;
    const name = carousel.querySelector('[data-camera-name]');
    const link = carousel.querySelector('[data-camera-link]');
    const source = carousel.querySelector('.ski-card__camera-source');
    const counter = carousel.querySelector('[data-camera-index]');

    const renderCamera = () => {
        name.textContent = cameras[index].name;
        link.href = cameras[index].url;
        source.href = cameras[index].url;
        counter.textContent = String(index + 1);
    };

    carousel.querySelector('[data-camera-prev]').addEventListener('click', () => {
        index = (index - 1 + cameras.length) % cameras.length;
        renderCamera();
    });
    carousel.querySelector('[data-camera-next]').addEventListener('click', () => {
        index = (index + 1) % cameras.length;
        renderCamera();
    });
});
