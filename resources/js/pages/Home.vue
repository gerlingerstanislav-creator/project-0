<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);
</script>

<template>
    <AppLayout>
        <Head title="Главная" />

        <main class="auth-page home-page">
            <section class="auth-card home-card">
                <p class="ds-label">PROJECT-0</p>
                <h1>Добро пожаловать</h1>
                <p class="auth-card__description">
                    Это личный набор инструментов проекта. Авторизуйтесь, чтобы получить доступ
                    к инструментам, материалам и дополнительным возможностям.
                </p>
                <Link v-if="!user" href="/login" class="home-card__login ds-button">Авторизоваться</Link>
            </section>
        </main>
    </AppLayout>
</template>
