<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);
const busy = ref(false);
const message = ref('');
const error = ref('');

const sendTestPush = async () => {
    busy.value = true;
    message.value = '';
    error.value = '';

    try {
        const response = await fetch('/push/test', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Не удалось отправить уведомление.');
        }

        message.value = data.sent > 0
            ? 'Тестовое уведомление отправлено.'
            : 'Активная push-подписка не найдена. Сначала включи уведомления в меню.';
    } catch (e) {
        error.value = e.message || 'Не удалось отправить уведомление.';
    } finally {
        busy.value = false;
    }
};
</script>

<template>
    <Head title="Тесты" />

    <AppLayout>
        <section class="page">
            <div class="page__header">
                <p class="page__eyebrow">TESTS</p>
                <h1>Тесты</h1>
                <p>Проверка PWA и push-уведомлений.</p>
            </div>

            <div class="card">
                <h2>Push-уведомление</h2>

                <template v-if="user">
                    <p>Отправить на текущую активную подписку тестовое уведомление.</p>
                    <button type="button" class="button" :disabled="busy" @click="sendTestPush">
                        {{ busy ? 'Отправка…' : 'Отправить тестовый push' }}
                    </button>
                    <p v-if="message">{{ message }}</p>
                    <p v-if="error">{{ error }}</p>
                </template>

                <template v-else>
                    <p>Для отправки тестового push необходимо войти в аккаунт.</p>
                    <Link href="/login" class="button">Войти</Link>
                </template>
            </div>
        </section>
    </AppLayout>
</template>
