<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Button from '../components/ui/Button.vue';
import Input from '../components/ui/Input.vue';
const form = useForm({ username: '', password: '' });
const submit = () => form.post('/login');
</script>
<template>
    <Head title="Авторизация — Инструменты" />
    <main class="auth-page">
        <section class="auth-card">
            <p class="ds-label">TOOLS</p>
            <h1>Авторизация</h1>
            <p class="auth-card__description">Войди в аккаунт, чтобы продолжить работу с инструментами.</p>
            <div v-if="form.errors.username" class="auth-card__error" role="alert">{{ form.errors.username }}</div>
            <form class="auth-form" @submit.prevent="submit">
                <label class="auth-form__label" for="username">Логин</label>
                <Input id="username" v-model="form.username" name="username" autocomplete="username" required />
                <label class="auth-form__label" for="password">Пароль</label>
                <Input id="password" v-model="form.password" name="password" type="password" autocomplete="current-password" required />
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Вход…' : 'Войти' }}</Button>
            </form>
        </section>
    </main>
</template>
