<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import Alert from '../components/ui/Alert.vue';
import Button from '../components/ui/Button.vue';
import Card from '../components/ui/Card.vue';
import { subscribeToPush } from '../push.js';

const busy = ref(false);
const error = ref('');

const sendTestPush = async () => {
    busy.value = true;
    error.value = '';

    try {
        await subscribeToPush();
        const response = await fetch('/push/test', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
        });
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Не удалось отправить тестовый push.');
        }

        if (data.sent < 1) {
            throw new Error('Тестовый push не был отправлен.');
        }
    } catch (e) {
        error.value = e.message || 'Не удалось отправить тестовый push.';
    } finally {
        busy.value = false;
    }
};
</script>

<template>
    <Head title="Тесты" />

    <AppLayout>
        <section class="page">
            <h1>Тесты</h1>
            <p class="page__description">Проверка функций, которые мы сейчас собираем в приложении.</p>

            <Card class="tests-card">
                <Button :disabled="busy" @click="sendTestPush">
                    {{ busy ? 'Отправка…' : 'Отправить тестовый push' }}
                </Button>

                <Alert v-if="error">{{ error }}</Alert>
            </Card>
        </section>
    </AppLayout>
</template>
