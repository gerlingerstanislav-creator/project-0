<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

defineProps({ cheatSheets: { type: Array, default: () => [] } });
</script>

<template>
    <Head title="Менеджерские шпаргалки" />
    <AppLayout>
        <section class="page startup-ideas">
            <p class="page__eyebrow">Page 04</p>
            <h1>Менеджерские шпаргалки</h1>
            <p class="page__description">Короткие практические материалы для подготовки к конкретным управленческим ситуациям.</p>
            <div class="startup-ideas__list">
                <details v-for="sheet in cheatSheets" :key="sheet.id" class="startup-idea">
                    <summary class="startup-idea__title"><span class="startup-idea__title-text">{{ sheet.title }}</span><span class="startup-idea__icon" aria-hidden="true">+</span></summary>
                    <div class="startup-idea__description" v-html="sheet.content"></div>
                </details>
                <div v-if="!cheatSheets.length" class="startup-ideas__empty">Пока нет шпаргалок.</div>
            </div>
        </section>
    </AppLayout>
</template>
