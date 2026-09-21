<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import PageHeader from '../components/ui/PageHeader.vue';
</script>
<template>
    <Head title="Инструмент 3" />
    <AppLayout>
        <section class="page">
            <PageHeader eyebrow="03 / TOOL" title="Инструмент 3" description="Каркас третьего инструмента. Здесь будет его собственная логика и интерфейс." />
        </section>
    </AppLayout>
</template>
