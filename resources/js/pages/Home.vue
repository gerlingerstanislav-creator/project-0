<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Главная" />

    <main class="auth-page home-page">
        <section class="auth-card home-card">
            <p class="ds-label">PROJECT-0</p>
            <h1>Добро пожаловать</h1>
            <p class="auth-card__description">
                Это личный набор инструментов проекта. Авторизуйтесь, чтобы получить доступ
                к инструментам, материалам и дополнительным возможностям.
            </p>
            <Link href="/login" class="home-card__login ds-button">Авторизоваться</Link>
        </section>
    </main>
</template>
