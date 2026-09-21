<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import Button from '../components/ui/Button.vue';
import Input from '../components/ui/Input.vue';
import PageHeader from '../components/ui/PageHeader.vue';

defineProps({ ideas: { type: Array, default: () => [] }, canEditIdeas: { type: Boolean, default: false } });
const editingId = ref(null);
const form = useForm({ title: '', description: '' });
const startEditing = (idea) => { editingId.value = idea.id; form.title = idea.title; form.description = idea.description; form.clearErrors(); };
const cancelEditing = () => { editingId.value = null; form.reset(); form.clearErrors(); };
const saveEditing = (idea) => form.patch(`/tool-1/ideas/${idea.id}`, { preserveScroll: true, onSuccess: cancelEditing });
</script>
<template>
    <Head title="Идеи для стартапов" />
    <AppLayout>
        <section class="page startup-ideas">
            <PageHeader eyebrow="01 / STARTUPS" title="Идеи для стартапов" description="Список идей из базы проекта.">
                <template #actions><span class="ds-badge">{{ canEditIdeas ? 'Редактирование доступно' : 'Только просмотр' }}</span></template>
            </PageHeader>
            <div class="startup-ideas__list">
                <details v-for="idea in ideas" :key="idea.id" class="startup-idea">
                    <summary class="startup-idea__title">
                            <span class="startup-idea__title-text">{{ editingId === idea.id ? form.title : idea.title }}</span>
                            <span class="startup-idea__icon" aria-hidden="true">+</span>
                        </summary>
                        <button v-if="canEditIdeas" class="startup-idea__edit" type="button" aria-label="Редактировать идею" @click.prevent="startEditing(idea)">✎</button>
                        <div v-if="editingId === idea.id" class="startup-idea__description">
                            <label class="startup-idea__field"><span>Название</span><Input v-model="form.title" maxlength="255" /><small v-if="form.errors.title">{{ form.errors.title }}</small></label>
                            <label class="startup-idea__field"><span>Описание</span><textarea v-model="form.description" rows="10"></textarea><small v-if="form.errors.description">{{ form.errors.description }}</small></label>
                        </div>
                        <div v-else class="startup-idea__description"><p>{{ idea.description }}</p></div>
                        <div v-if="editingId === idea.id" class="startup-idea__actions">
                            <Button variant="secondary" @click="cancelEditing">Отмена</Button>
                            <Button :disabled="form.processing" @click="saveEditing(idea)">{{ form.processing ? 'Сохранение…' : 'Сохранить' }}</Button>
                        </div>
                </details>
                <div v-if="ideas.length === 0" class="startup-ideas__empty">Пока нет идей.</div>
            </div>
        </section>
    </AppLayout>
</template>
