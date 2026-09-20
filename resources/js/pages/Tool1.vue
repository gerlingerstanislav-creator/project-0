<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

defineProps({
    ideas: {
        type: Array,
        default: () => [],
    },
    canEditIdeas: {
        type: Boolean,
        default: false,
    },
});

const editingId = ref(null);
const form = useForm({
    title: '',
    description: '',
});

const startEditing = (idea) => {
    editingId.value = idea.id;
    form.title = idea.title;
    form.description = idea.description;
    form.clearErrors();
};

const cancelEditing = () => {
    editingId.value = null;
    form.reset();
    form.clearErrors();
};

const saveEditing = (idea) => {
    form.patch(`/tool-1/ideas/${idea.id}`, {
        preserveScroll: true,
        onSuccess: cancelEditing,
    });
};
</script>

<template>
    <Head title="Идеи для стартапов" />

    <AppLayout>
        <section class="page startup-ideas">
            <p class="page__eyebrow">Page 01</p>
            <h1>Идеи для стартапов</h1>
            <p class="page__description">
                Список идей из базы проекта.
                {{ canEditIdeas
                    ? 'Наведи на идею и нажми карандаш, чтобы изменить название или описание.'
                    : 'Доступно только просмотр и раскрытие описаний.' }}
            </p>

            <div class="startup-ideas__list">
                <details v-for="idea in ideas" :key="idea.id" class="startup-idea">
                    <summary class="startup-idea__title">
                        <span class="startup-idea__title-text">
                            {{ editingId === idea.id ? form.title : idea.title }}
                        </span>
                        <span class="startup-idea__icon" aria-hidden="true">+</span>
                    </summary>

                    <button
                        v-if="canEditIdeas"
                        class="startup-idea__edit"
                        type="button"
                        aria-label="Редактировать идею"
                        @click.prevent="startEditing(idea)"
                    >
                        <span aria-hidden="true">✎</span>
                    </button>

                    <div v-if="editingId === idea.id" class="startup-idea__description">
                        <label class="startup-idea__field">
                            <span>Название</span>
                            <input v-model="form.title" type="text" maxlength="255">
                            <small v-if="form.errors.title">{{ form.errors.title }}</small>
                        </label>
                        <label class="startup-idea__field">
                            <span>Описание</span>
                            <textarea v-model="form.description" rows="10"></textarea>
                            <small v-if="form.errors.description">{{ form.errors.description }}</small>
                        </label>
                    </div>

                    <div v-else class="startup-idea__description">
                        <p>{{ idea.description }}</p>
                    </div>

                    <div v-if="editingId === idea.id" class="startup-idea__actions">
                        <button
                            class="startup-idea__button startup-idea__button--secondary"
                            type="button"
                            @click="cancelEditing"
                        >
                            Отмена
                        </button>
                        <button
                            class="startup-idea__button"
                            type="button"
                            :disabled="form.processing"
                            @click="saveEditing(idea)"
                        >
                            Сохранить
                        </button>
                    </div>
                </details>

                <div v-if="ideas.length === 0" class="startup-ideas__empty">
                    Пока нет идей.
                </div>
            </div>
        </section>
    </AppLayout>
</template>
