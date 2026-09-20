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
    const cities = JSON.parse(atob(weatherApp.dataset.cities));
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
            weekday: 'long',
            day: 'numeric',
            month: 'long',
        }).format(new Date(date + 'T12:00:00'));

        return index === 0 ? 'Сегодня, ' + formatted.replace(/^[а-яё]+, /, '') : 'Завтра, ' + formatted.replace(/^[а-яё]+, /, '');
    };

    const iconFor = (code) => code >= 95 ? '⚡' : code >= 80 ? '🌧️' : code >= 71 ? '❄️' : code >= 51 ? '🌦️' : code >= 1 ? '⛅' : '☀️';

    const renderCity = (city, data) => {
        const daily = data.daily;

        return `
            <article class="weather-card">
                <div class="weather-card__top">
                    <img class="weather-card__photo" src="${city.photo}" alt="${city.name}" loading="lazy">
                    <div>
                        <h2>${city.name}</h2>
                        <p>${city.region}</p>
                    </div>
                </div>
                <div class="weather-table-wrap">
                    <table class="weather-table">
                        <thead>
                            <tr><th>Дата</th><th>Погода</th><th>Температура</th><th>Осадки</th></tr>
                        </thead>
                        <tbody>
                            ${daily.time.map((date, index) => `
                                <tr>
                                    <th scope="row">${formatDate(date, index)}</th>
                                    <td><span class="weather-table__icon" aria-hidden="true">${iconFor(daily.weather_code[index])}</span> ${weatherDescriptions[daily.weather_code[index]] ?? 'Погодные условия'}</td>
                                    <td><strong>${Math.round(daily.temperature_2m_max[index])}°</strong> / ${Math.round(daily.temperature_2m_min[index])}°</td>
                                    <td>${daily.precipitation_probability_max[index] ?? 0}%</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <div class="weather-card__updated">Данные обновляются автоматически каждую минуту · источник: Open-Meteo</div>
            </article>
        `;
    };

    const renderError = (city) => `
        <article class="weather-card weather-card--error">
            <div class="weather-card__top">
                <img class="weather-card__photo" src="${city.photo}" alt="${city.name}" loading="lazy">
                <div><h2>${city.name}</h2><p>${city.region}</p></div>
            </div>
            <p class="weather-card__error">Не удалось получить актуальный прогноз. Попробуйте обновить страницу.</p>
        </article>
    `;

    const loadWeather = async () => {
        await Promise.all(cities.map(async (city) => {
            const url = new URL('https://api.open-meteo.com/v1/forecast');
            url.search = new URLSearchParams({
                latitude: city.latitude,
                longitude: city.longitude,
                current: 'temperature_2m,weather_code',
                daily: 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max',
                forecast_days: '2',
                timezone: 'auto',
            });

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('weather_request_failed');
                const data = await response.json();
                const target = document.querySelector(`[data-weather-city="${city.id}"]`);
                if (target) target.innerHTML = renderCity(city, data);
            } catch {
                const target = document.querySelector(`[data-weather-city="${city.id}"]`);
                if (target) target.innerHTML = renderError(city);
            }
        }));
    };

    loadWeather();
    window.setInterval(loadWeather, refreshInterval);
}
