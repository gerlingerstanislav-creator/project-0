<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import PageHeader from '../components/ui/PageHeader.vue';

const props = defineProps({
    articles: { type: Array, default: () => [] },
    sources: { type: Array, default: () => [] },
    updatedAt: { type: String, default: '' },
    selectedCategories: { type: Array, default: () => [] },
    minImportance: { type: Number, default: 0.45 },
});

const categories = ['Для тебя', 'IT', 'AI', 'Программирование', 'Стартапы', 'Бизнес', 'Управление', 'Наука', 'Мир', 'Политика', 'Спорт'];
const selected = ref(props.selectedCategories.length ? props.selectedCategories : ['Для тебя']);
const importance = ref(props.minImportance);
const showOriginal = ref(false);

const visible = computed(() => {
    let list = props.articles.filter((article) => article.importance >= importance.value);

    if (selected.value.includes('Для тебя')) {
        list = list.filter((article) => article.relevance >= 0.55);
    } else {
        list = list.filter((article) => selected.value.some((category) => article.categories.includes(category)));
    }

    return list;
});

const toggleCategory = (category) => {
    if (category === 'Для тебя') {
        selected.value = ['Для тебя'];
        return;
    }

    selected.value = selected.value.filter((item) => item !== 'Для тебя');
    if (selected.value.includes(category)) {
        selected.value = selected.value.filter((item) => item !== category);
    } else {
        selected.value.push(category);
    }

    if (!selected.value.length) {
        selected.value = ['Для тебя'];
    }
};

const importanceLabel = computed(() => {
    if (importance.value >= 0.8) return 'Только очень важное';
    if (importance.value >= 0.65) return 'Важное';
    if (importance.value >= 0.5) return 'Заметное';
    return 'Показывать больше';
});

const formatDate = (value) => new Intl.DateTimeFormat('ru-RU', {
    day: '2-digit',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit',
}).format(new Date(value));

const formatSources = (article) => article.source_count > 1
    ? `${article.source_count} источника`
    : article.sources[0];
</script>

<template>
    <Head title="Новости" />
    <AppLayout>
        <section class="page news-page">
            <PageHeader eyebrow="08 / NEWS" title="Новости" description="Агрегатор, который сначала отбирает значимые события, а затем учитывает твои интересы. Несколько источников одного события объединяются." />

            <div class="news-controls">
                <div class="news-controls__group">
                    <span class="news-controls__label">Категории</span>
                    <div class="news-categories">
                        <button
                            v-for="category in categories"
                            :key="category"
                            type="button"
                            class="news-chip"
                            :class="{ 'is-active': selected.includes(category) }"
                            @click="toggleCategory(category)"
                        >
                            {{ category }}
                        </button>
                    </div>
                </div>

                <label class="news-importance">
                    <span class="news-controls__label">Минимальная значимость: {{ importanceLabel }}</span>
                    <input v-model.number="importance" type="range" min="0.45" max="0.85" step="0.05">
                </label>
            </div>

            <div class="news-meta">
                <button type="button" class="news-chip" :class="{ 'is-active': !showOriginal }" @click="showOriginal = !showOriginal">
                    {{ showOriginal ? 'Показывать перевод' : 'Показывать оригинал' }}
                </button>
                <span>{{ visible.length }} новостей</span>
                <span>{{ sources.length }} источников</span>
                <span>Обновлено {{ updatedAt ? formatDate(updatedAt) : '—' }}</span>
            </div>

            <div class="news-list">
                <article v-for="article in visible" :key="article.url" class="news-card">
                    <div class="news-card__top">
                        <div class="news-card__categories">
                            <span v-for="category in article.categories.slice(0, 4)" :key="category">{{ category }}</span>
                        </div>
                        <span class="news-card__importance">Значимость {{ Math.round(article.importance * 100) }}%</span>
                    </div>

                    <h2 class="news-card__title">
                        <a :href="article.url" target="_blank" rel="noopener noreferrer">{{ showOriginal || !article.title_ru ? article.title : article.title_ru }}</a>
                    </h2>

                    <p v-if="article.description" class="news-card__description">{{ showOriginal || !article.description_ru ? article.description : article.description_ru }}</p>

                    <div class="news-card__bottom">
                        <span>{{ formatSources(article) }}</span>
                        <span>{{ formatDate(article.published_at) }}</span>
                    </div>

                    <div class="news-card__why">
                        <span>Почему здесь:</span>
                        <span v-for="reason in article.why" :key="reason">{{ reason }}</span>
                    </div>
                </article>

                <div v-if="!visible.length" class="news-empty">
                    Нет новостей с текущими настройками. Попробуй снизить порог значимости или выбрать другую категорию.
                </div>
            </div>

            <p class="news-disclaimer">
                Лента строится эвристически: значимость и релевантность — разные показатели. Алгоритм пока прозрачен и не использует политические предпочтения пользователя.
            </p>
        </section>
    </AppLayout>
</template>
