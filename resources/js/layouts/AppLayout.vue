<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { appLinks } from '../navigation.js';
import { usePush } from '../composables/usePush.js';
import Button from '../components/ui/Button.vue';

const page = usePage();
const menuOpen = ref(false);
const { pushState, pushBusy, pushError, togglePush } = usePush();
const installAvailable = ref(false);
const user = computed(() => page.props.auth?.user ?? null);
const currentPath = computed(() => page.url.split('?')[0]);
const links = appLinks;
const isActive = (href) => currentPath.value === href;
const closeMenu = () => { menuOpen.value = false; };
const requestInstall = () => window.dispatchEvent(new Event('pwa-install-request'));
if (typeof window !== 'undefined') { window.addEventListener('pwa-install-available', () => { installAvailable.value = true; }); }
</script>

<template>
    <button
        class="menu-toggle"
        type="button"
        aria-controls="sidebar"
        :aria-expanded="menuOpen"
        @click="menuOpen = !menuOpen"
    >
        <span></span>
        <span></span>
        <span></span>
        <span class="sr-only">{{ menuOpen ? 'Закрыть меню' : 'Открыть меню' }}</span>
    </button>

    <aside id="sidebar" class="sidebar" :class="{ 'is-open': menuOpen }">
        <div class="sidebar__brand">project-0</div>

        <nav class="sidebar__nav" aria-label="Основная навигация">
            <template v-for="link in links" :key="link.href">
                <Link
                    :href="link.href"
                    class="sidebar__link"
                    :class="{ 'is-active': isActive(link.href) }"
                    @click="closeMenu"
                >
                    <span>{{ link.number }}</span>
                    {{ link.label }}
                </Link>
            </template>
        </nav>

        <div class="sidebar__account">
            <template v-if="user">
                <div class="sidebar__account-label">Аккаунт</div>
                <div class="sidebar__account-name">{{ user.username }}</div>
                <div class="sidebar__account-role">
                    {{ user.role === 'admin' ? 'Администратор' : user.role === 'editor' ? 'Редактор' : 'Наблюдатель' }}
                </div>
                <Button v-if="pushState === 'available' || pushState === 'subscribed'" variant="secondary" type="button" class="sidebar__push" :disabled="pushBusy" @click="togglePush">{{ pushBusy ? 'Подключение…' : pushState === 'subscribed' ? 'Отключить уведомления' : 'Включить уведомления' }}</Button>
                <Button v-if="installAvailable" variant="secondary" type="button" class="sidebar__push" @click="requestInstall">Установить приложение</Button>
                <small v-if="pushError" class="sidebar__push-error">{{ pushError }}</small>
                <Button
                    type="button"
                    variant="secondary"
                    class="sidebar__logout"
                    @click="router.post('/logout', {}, { preserveScroll: true, onSuccess: closeMenu })"
                >
                    Выйти
                </Button>
            </template>

            <Link v-else href="/login" class="sidebar__login" @click="closeMenu">Войти</Link>
        </div>
    </aside>

    <main class="content">
        <Transition name="page" mode="out-in" appear>
            <div :key="page.component" class="page-transition">
                <slot />
            </div>
        </Transition>
    </main>

    <button
        v-if="menuOpen"
        class="sidebar-backdrop"
        type="button"
        aria-label="Закрыть меню"
        @click="closeMenu"
    ></button>
</template>
