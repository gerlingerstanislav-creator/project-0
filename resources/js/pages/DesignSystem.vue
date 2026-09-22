<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import Alert from '../components/ui/Alert.vue';
import Badge from '../components/ui/Badge.vue';
import Button from '../components/ui/Button.vue';
import Card from '../components/ui/Card.vue';
import Input from '../components/ui/Input.vue';
import PageHeader from '../components/ui/PageHeader.vue';

const tokens = [
    ['Background', '--ds-color-background', '#f4f4f5'],
    ['Surface', '--ds-color-surface', '#ffffff'],
    ['Foreground', '--ds-color-foreground', '#18181b'],
    ['Muted text', '--ds-color-foreground-muted', '#71717a'],
    ['Border', '--ds-color-border', '#e4e4e7'],
    ['Accent', '--ds-color-accent', '#18181b'],
    ['Danger', '--ds-color-danger', '#b91c1c'],
];

const spacing = [
    ['1', '4px'], ['2', '8px'], ['3', '12px'], ['4', '16px'],
    ['5', '20px'], ['6', '24px'], ['8', '32px'], ['10', '40px'],
];

const components = [
    ['Button', 'Primary / Secondary / Disabled'],
    ['Badge', 'Neutral / Success / Danger'],
    ['Alert', 'Danger / error feedback'],
    ['Card', 'Surface container'],
    ['Input', 'Text / disabled / required / v-model'],
    ['PageHeader', 'Eyebrow / title / description / actions'],
];
</script>

<template>
    <Head title="Design System" />
    <AppLayout>
        <main class="ds-catalog">
            <PageHeader
                eyebrow="SYSTEM / UI"
                title="Design System"
                description="Живой каталог токенов и компонентов project-0. Здесь собраны актуальные building blocks, состояния и базовые правила интерфейса."
            />

            <section class="ds-catalog__section">
                <h2>Components</h2>
                <div class="ds-catalog__component-grid">
                    <Card v-for="[name, description] in components" :key="name">
                        <strong>{{ name }}</strong>
                        <span>{{ description }}</span>
                    </Card>
                </div>
            </section>

            <section class="ds-catalog__section">
                <h2>Buttons</h2>
                <div class="ds-catalog__row">
                    <Button>Primary</Button>
                    <Button variant="secondary">Secondary</Button>
                    <Button disabled>Disabled</Button>
                </div>
            </section>

            <section class="ds-catalog__section">
                <h2>Forms</h2>
                <Card>
                    <label class="ds-catalog__field">
                        <span class="ds-label">Default input</span>
                        <Input placeholder="Введите значение…"></Input>
                    </label>
                    <label class="ds-catalog__field">
                        <span class="ds-label">Disabled input</span>
                        <Input model-value="Недоступно" disabled />
                    </label>
                </Card>
            </section>

            <section class="ds-catalog__section">
                <h2>Feedback</h2>
                <div class="ds-catalog__row">
                    <Badge>Neutral</Badge>
                    <Badge variant="success">Success</Badge>
                    <Badge variant="danger">Error</Badge>
                </div>
                <Alert>Пример сообщения об ошибке с понятным следующим действием.</Alert>
            </section>

            <section class="ds-catalog__section">
                <h2>Design tokens</h2>
                <div class="ds-token-list">
                    <div v-for="[name, variable, value] in tokens" :key="variable" class="ds-token-row">
                        <span class="ds-token-swatch" :style="{ background: value }" />
                        <strong>{{ name }}</strong>
                        <code>{{ variable }}</code>
                        <span>{{ value }}</span>
                    </div>
                </div>
            </section>

            <section class="ds-catalog__section">
                <h2>Spacing</h2>
                <div class="ds-spacing-list">
                    <div v-for="[step, value] in spacing" :key="step" class="ds-spacing-row">
                        <span class="ds-spacing-bar" :style="{ width: value }" />
                        <code>--ds-space-{{ step }}</code>
                        <span>{{ value }}</span>
                    </div>
                </div>
            </section>

            <section class="ds-catalog__section">
                <h2>Page header</h2>
                <Card>
                    <PageHeader eyebrow="EXAMPLE / PAGE" title="Заголовок страницы" description="Стандартный компонент заголовка с описанием и опциональным action." >
                        <template #actions>
                            <Button variant="secondary">Action</Button>
                        </template>
                    </PageHeader>
                </Card>
            </section>

            <p class="ds-catalog__note">При создании новых экранов сначала используй существующие компоненты и токены. Повторяющиеся UI-паттерны добавляй в этот каталог и дизайн-систему.</p>
        </main>
    </AppLayout>
</template>
