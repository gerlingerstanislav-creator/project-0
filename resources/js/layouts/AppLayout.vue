<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { getPushState, subscribeToPush, unsubscribeFromPush } from '../push.js';

const page = usePage();
const menuOpen = ref(false);
const pushState = ref('unknown');
const pushBusy = ref(false);
const pushError = ref('');
const installAvailable = ref(false);

const user = computed(() => page.props.auth?.user ?? null);
const currentPath = computed(() => page.url.split('?')[0]);

const links = [
    { href: '/tool-1', label: 'Идеи стартапов', number: '1' },
    { href: '/tool-2', label: 'Инструмент 2', number: '2' },
    { href: '/tool-3', label: 'Инструмент 3', number: '3' },
    { href: '/manager-cheat-sheets', label: 'Менеджерские шпаргалки', number: '4' },
    { href: '/ski-resort', label: 'Горнолыжные курорты', number: '5' },
];

const isActive = (href) => currentPath.value === href;
const closeMenu = () => { menuOpen.value = false; };
const refreshPushState = async () => { try { pushState.value = await getPushState(); } catch { pushState.value = 'unsupported'; } };
const togglePush = async () => { pushBusy.value = true; pushError.value = ''; try { if (pushState.value === 'subscribed') await unsubscribeFromPush(); else await subscribeToPush(); await refreshPushState(); } catch (error) { pushError.value = error.message; } finally { pushBusy.value = false; } };
const requestInstall = () => window.dispatchEvent(new Event('pwa-install-request'));
if (typeof window !== 'undefined') { refreshPushState(); window.addEventListener('pwa-install-available', () => { installAvailable.value = true; }); }
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
                <button v-if="pushState === 'available' || pushState === 'subscribed'" type="button" class="sidebar__push" :disabled="pushBusy" @click="togglePush">{{ pushBusy ? 'Подключение…' : pushState === 'subscribed' ? 'Отключить уведомления' : 'Включить уведомления' }}</button>
                <button v-if="installAvailable" type="button" class="sidebar__push" @click="requestInstall">Установить приложение</button>
                <small v-if="pushError" class="sidebar__push-error">{{ pushError }}</small>
                <form method="POST" action="/logout">
                    <input type="hidden" name="_token" :value="page.props.csrfToken">
                    <button type="submit" class="sidebar__logout" @click="closeMenu">Выйти</button>
                </form>
            </template>

            <a v-else href="/login" class="sidebar__login" @click="closeMenu">Войти</a>
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
