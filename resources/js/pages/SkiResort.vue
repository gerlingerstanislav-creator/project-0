<script setup>
import { onMounted, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import PageHeader from '../components/ui/PageHeader.vue';

const props = defineProps({ resorts: { type: Array, default: () => [] } });
const cameras = ref({});
const forecasts = ref({});
const temperatures = ref({});

const camera = (id) => cameras.value[id] ?? 0;
const setCamera = (id, index) => {
    const count = props.resorts.find(r => r.id === id)?.cameras?.length ?? 1;
    cameras.value[id] = (index + count) % count;
};
const weatherDescription = (code) => {
    if ([0,1].includes(code)) return 'Ясно';
    if ([2,3].includes(code)) return 'Облачно';
    if ([45,48].includes(code)) return 'Туман';
    if ([51,53,55,56,57].includes(code)) return 'Морось';
    if ([61,63,65,66,67].includes(code)) return 'Дождь';
    if ([71,73,75,77].includes(code)) return 'Снег';
    if ([80,81,82].includes(code)) return 'Ливень';
    if ([85,86].includes(code)) return 'Снегопад';
    if ([95,96,99].includes(code)) return 'Гроза';
    return '—';
};

const loadWeather = async (resort) => {
    try {
        const params = new URLSearchParams({
            latitude: resort.latitude,
            longitude: resort.longitude,
            current: 'temperature_2m,weather_code',
            daily: 'weather_code,temperature_2m_max,temperature_2m_min',
            timezone: 'auto',
            forecast_days: '5',
        });
        const response = await fetch(`https://api.open-meteo.com/v1/forecast?${params}`);
        if (!response.ok) throw new Error('Weather request failed');
        const data = await response.json();

        temperatures.value[resort.id] = data.current?.temperature_2m ?? null;
        forecasts.value[resort.id] = data.daily?.time?.map((date, i) => ({
            date,
            code: data.daily.weather_code[i],
            max: data.daily.temperature_2m_max[i],
            min: data.daily.temperature_2m_min[i],
        })) ?? [];
    } catch {
        temperatures.value[resort.id] = null;
        forecasts.value[resort.id] = [];
    }
};

const seasonStatus = (resort) => {
    const year = new Date().getFullYear();
    const openMonth = ['sheregesh', 'bigwood'].includes(resort.id) ? 10 : 11;
    const open = new Date(year, openMonth, 1);
    const close = new Date(year + 1, 4, 31, 23, 59, 59);
    return new Date() >= open && new Date() <= close
        ? { status: 'open', label: 'Активен' }
        : { status: 'closed', label: 'Не активен' };
};
onMounted(() => props.resorts.forEach(loadWeather));
</script>

<template>
    <Head title="Горнолыжные курорты" />
    <AppLayout>
        <section class="page ski-page">
            <PageHeader title="Горнолыжные курорты" description="Погода, камеры и состояние горнолыжного сезона на горнолыжных курортах России.">
                <template #actions><span class="ds-badge">Обновляется автоматически</span></template>
            </PageHeader>
            <div class="ski-page__cards">
                <article v-for="resort in props.resorts" :key="resort.id" class="ski-card">
                    <div class="ski-card__top">
                        <div class="ski-card__media">
                            <template v-for="(cam, index) in resort.cameras" :key="index">
                                <iframe v-if="camera(resort.id) === index && cam.type === 'video'" class="ski-card__camera-frame" :src="cam.playerUrl" :title="cam.name" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                <img v-else-if="camera(resort.id) === index && cam.type === 'image'" class="ski-card__camera-image" :src="`${cam.imageUrl}?t=${Date.now()}`" :alt="cam.name">
                                <div v-else-if="camera(resort.id) === index" class="ski-card__camera-placeholder"><div class="ski-card__camera-icon">◉</div><strong>{{ cam.name }}</strong><span>Прямой поток открыт на сайте источника.</span><a :href="cam.url" target="_blank" rel="noopener">Открыть камеру ↗</a></div>
                            </template>
                            <template v-if="resort.cameras.length > 1">
                                <button class="ski-card__camera-arrow ski-card__camera-arrow--prev" type="button" @click="setCamera(resort.id, camera(resort.id) - 1)">‹</button>
                                <button class="ski-card__camera-arrow ski-card__camera-arrow--next" type="button" @click="setCamera(resort.id, camera(resort.id) + 1)">›</button>
                                <div class="ski-card__camera-counter">{{ camera(resort.id) + 1 }} / {{ resort.cameras.length }}</div>
                            </template>
                            <a class="ski-card__camera-source" :href="resort.cameras[camera(resort.id)].url" target="_blank" rel="noopener">Источник камер ↗</a>
                        </div>
                        <div class="ski-card__body">
                            <div class="ski-card__heading"><div><h2 class="ski-card__title">{{ resort.name }}</h2><p class="ski-card__region">{{ resort.region }}</p></div><span :class="`ski-card__status ski-card__status--${resort.status}`">{{ resort.statusLabel }}</span></div>
                            <div class="ski-card__meta"><div class="ski-card__meta-item"><div class="ski-card__meta-label">Сезон</div><div class="ski-card__meta-value">с {{ resort.seasonStart }} по {{ resort.seasonEnd }}</div></div><div class="ski-card__meta-item"><div class="ski-card__meta-label">Сейчас</div><div class="ski-card__meta-value">{{ temperatures[resort.id] !== null && temperatures[resort.id] !== undefined ? Math.round(temperatures[resort.id]) + '°C' : '—' }}</div></div></div>
                        </div>
                    </div>
                    <div class="ski-card__forecast">
                        <div v-if="!forecasts[resort.id]" class="weather-row weather-row--loading">Загружаем прогноз…</div>
                        <div v-for="day in forecasts[resort.id]" :key="day.date" class="weather-row"><span>{{ new Date(day.date).toLocaleDateString('ru-RU', { weekday: 'short' }) }}</span><strong>{{ Math.round(day.max) }}° / {{ Math.round(day.min) }}°</strong><span>{{ weatherDescription(day.code) }}</span></div>
                    </div>
                    <div class="ski-card__updated">{{ resort.seasonDescription }} · источник погоды: Open-Meteo</div>
                </article>
            </div>
            <p class="page__eyebrow">06 / SKI RESORTS</p>
        </section>
    </AppLayout>
</template>
