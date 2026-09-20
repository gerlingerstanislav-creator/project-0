<script setup>
import { Head, useForm } from '@inertiajs/vue3';
const form = useForm({ username: '', password: '' });
const submit = () => form.post('/login');
</script>
<template>
    <Head title="Авторизация — Инструменты" />
    <main class="auth-page">
        <div class="auth-card">
            <p class="page__eyebrow">Tools</p><h1>Авторизация</h1><p class="auth-card__description">Войди в аккаунт, чтобы продолжить работу с инструментами.</p>
            <div v-if="form.errors.username" class="auth-card__error" role="alert">{{ form.errors.username }}</div>
            <form class="auth-form" @submit.prevent="submit">
                <label class="auth-form__label" for="username">Логин</label><input id="username" v-model="form.username" class="auth-form__input" type="text" autocomplete="username" required autofocus>
                <label class="auth-form__label" for="password">Пароль</label><input id="password" v-model="form.password" class="auth-form__input" type="password" autocomplete="current-password" required>
                <button class="auth-form__submit" type="submit" :disabled="form.processing">Войти</button>
            </form>
        </div>
    </main>
</template>
